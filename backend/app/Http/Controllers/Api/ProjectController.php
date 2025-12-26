<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Use cache key based on request parameters
        $cacheKey = 'projects_' . md5($request->getQueryString());
        
        $projects = cache()->remember($cacheKey, 300, function () use ($request) {
            $query = Project::query()->orderBy('order');

            // Filter by category if provided
            if ($request->has('category') && in_array($request->category, ['frontend', 'backend', 'fullstack'])) {
                $query->where('category', $request->category);
            }

            // Paginate if page parameter is present
            if ($request->has('page')) {
                $perPage = $request->input('per_page', 6);
                return $query->paginate($perPage);
            }

            return $query->get();
        });

        return response()->json($projects)->withHeaders([
            'Cache-Control' => 'public, max-age=60', // Cache for 1 minute (reduced for faster updates)
        ]);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail_path' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['string'],
            'tech_stack' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'in:frontend,backend,fullstack'],
            'github_url' => ['nullable', 'url'],
            'live_url' => ['nullable', 'url'],
            'is_featured' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $project = Project::create($data);
        
        // Clear all project caches (including different query variations)
        $this->clearProjectCaches();

        return response()->json($project, 201);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $data = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', 'unique:projects,slug,' . $project->id],
            'short_description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'thumbnail_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'images' => ['sometimes', 'nullable', 'array'],
            'images.*' => ['string'],
            'tech_stack' => ['sometimes', 'nullable', 'string', 'max:255'],
            'category' => ['sometimes', 'nullable', 'in:frontend,backend,fullstack'],
            'github_url' => ['sometimes', 'nullable', 'url'],
            'live_url' => ['sometimes', 'nullable', 'url'],
            'is_featured' => ['sometimes', 'boolean'],
            'order' => ['sometimes', 'nullable', 'integer'],
        ]);

        $project->update($data);
        
        // Clear all project caches (including different query variations)
        $this->clearProjectCaches();

        return response()->json($project->fresh());
    }

    public function destroy($id)
    {
        try {
            $project = Project::find($id);

            if (!$project) {
                // Project doesn't exist - treat as already deleted (idempotent delete)
                return response()->json(null, 204);
            }

            // Delete project images if they exist
            if ($project->images && is_array($project->images)) {
                foreach ($project->images as $imageUrl) {
                    $this->deleteImageFromUrl($imageUrl);
                }
            }

            // Delete thumbnail if it exists
            if ($project->thumbnail_path) {
                $this->deleteImageFromUrl($project->thumbnail_path);
            }

            $project->delete();
            
            // Clear all project caches (including different query variations)
            $this->clearProjectCaches();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            $message = config('app.debug') 
                ? 'Error deleting project: ' . $e->getMessage()
                : 'Unable to delete the project. Please try again.';
                
            return response()->json([
                'message' => $message,
                'error' => 'delete_failed'
            ], 500);
        }
    }

    /**
     * Upload project images.
     */
    public function uploadImages(Request $request): JsonResponse
    {
        try {
            // Check PHP upload limits first
            $uploadMaxSize = $this->convertToBytes(ini_get('upload_max_filesize'));
            $postMaxSize = $this->convertToBytes(ini_get('post_max_size'));
            $maxAllowed = min($uploadMaxSize, $postMaxSize, 5 * 1024 * 1024); // 5MB max, but limited by PHP settings
            $maxAllowedKB = (int)($maxAllowed / 1024); // Convert to KB for validation
            
            // Validate the request - Laravel handles both 'images' and 'images[]' automatically
            $validated = $request->validate([
                'images' => ['required', 'array', 'min:1', 'max:10'],
                'images.*' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:' . $maxAllowedKB],
            ]);

            $images = $request->file('images');
            
            // Check if files were actually uploaded
            if (!$images || count($images) === 0) {
                return response()->json([
                    'message' => 'No files were uploaded. Please check file size limits (max ' . round($maxAllowed / 1024 / 1024, 1) . 'MB).',
                    'error' => 'no_files_uploaded',
                ], 422);
            }
            
            $uploadedUrls = [];

            foreach ($images as $index => $image) {
                // Double-check file is valid
                if (!$image->isValid()) {
                    return response()->json([
                        'message' => "Image {$index} failed to upload. File may be too large (max " . round($maxAllowed / 1024 / 1024, 1) . "MB) or corrupted.",
                        'error' => 'invalid_file',
                    ], 422);
                }
                
                $filename = 'project_' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('projects', $filename, 'public');
                // Use Storage::url() for proper URL generation
                $uploadedUrls[] = Storage::disk('public')->url($path);
            }

            return response()->json([
                'message' => 'Images uploaded successfully',
                'urls' => $uploadedUrls,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorMessage = 'Validation failed';
            
            // Calculate max allowed for error message
            $uploadMaxSize = $this->convertToBytes(ini_get('upload_max_filesize'));
            $postMaxSize = $this->convertToBytes(ini_get('post_max_size'));
            $maxAllowedMB = round(min($uploadMaxSize, $postMaxSize, 5 * 1024 * 1024) / 1024 / 1024, 1);
            
            // Extract specific error messages
            foreach ($errors as $field => $messages) {
                if (isset($messages[0])) {
                    $errorMessage = $messages[0];
                    // Make error messages more user-friendly
                    if (str_contains($errorMessage, 'may not be greater than') || str_contains($errorMessage, 'failed to upload')) {
                        $errorMessage = "The image file is too large. Maximum allowed size is {$maxAllowedMB}MB. Please choose a smaller file.";
                    }
                    break;
                }
            }
            
            return response()->json([
                'message' => $errorMessage,
                'error' => 'validation_failed',
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            // Don't expose internal error details in production
            $message = config('app.debug') 
                ? 'Upload failed: ' . $e->getMessage()
                : 'Upload failed. Please try again.';
                
            return response()->json([
                'message' => $message,
                'error' => 'upload_failed',
            ], 500);
        }
    }

    /**
     * Convert PHP ini size format (e.g., "2M", "5120K") to bytes
     */
    private function convertToBytes(string $size): int
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;

        switch ($last) {
            case 'g':
                $size *= 1024;
                // no break
            case 'm':
                $size *= 1024;
                // no break
            case 'k':
                $size *= 1024;
        }

        return $size;
    }

    /**
     * Delete a project image.
     */
    public function deleteImage(Request $request): JsonResponse
    {
        $request->validate([
            'url' => ['required', 'string'],
        ]);

        $this->deleteImageFromUrl($request->url);

        return response()->json([
            'message' => 'Image deleted successfully',
        ]);
    }

    /**
     * Delete an image file from storage given its URL.
     */
    private function deleteImageFromUrl(string $url): void
    {
        $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));
        
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Clear all project-related caches.
     */
    private function clearProjectCaches(): void
    {
        // Clear cache for common query variations
        cache()->forget('projects_' . md5('')); // No query params
        cache()->forget('projects_' . md5('category=frontend'));
        cache()->forget('projects_' . md5('category=backend'));
        cache()->forget('projects_' . md5('category=fullstack'));
        
        // Also clear any paginated caches
        for ($page = 1; $page <= 10; $page++) {
            cache()->forget('projects_' . md5("page={$page}"));
            cache()->forget('projects_' . md5("page={$page}&per_page=6"));
        }
    }
}
