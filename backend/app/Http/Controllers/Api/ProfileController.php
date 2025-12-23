<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        $profile = Profile::first();

        return response()
            ->json($profile)
            ->withHeaders(['Cache-Control' => 'public, max-age=300']);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'role' => ['sometimes', 'nullable', 'string', 'max:255'],
            'headline' => ['sometimes', 'nullable', 'string', 'max:255'],
            'bio' => ['sometimes', 'nullable', 'string'],
            'location' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'languages' => ['sometimes', 'nullable', 'string', 'max:255'],
            'social_links' => ['sometimes', 'nullable', 'json'],
        ]);

        $profile = Profile::firstOrFail();
        $profile->update($validated);

        return response()->json($profile->fresh());
    }

    public function uploadResume(Request $request): JsonResponse
    {
        $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $profile = Profile::firstOrFail();

        $this->deleteResumeFile($profile);

        $file = $request->file('resume');
        $filename = 'resume_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('resumes', $filename, 'public');

        $resumeUrl = asset('storage/' . $path);
        $profile->update(['resume_url' => $resumeUrl]);

        return response()->json([
            'message' => 'Resume uploaded successfully',
            'resume_url' => $resumeUrl,
        ]);
    }

    public function deleteResume(): JsonResponse
    {
        $profile = Profile::firstOrFail();

        $this->deleteResumeFile($profile);
        $profile->update(['resume_url' => null]);

        return response()->json(['message' => 'Resume deleted successfully']);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // 5MB max
        ]);

        $profile = Profile::firstOrFail();
        
        // Store old avatar path before deletion (if exists)
        $oldAvatarPath = $profile->avatar_path;

        $file = $request->file('avatar');
        $filename = 'avatar_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('avatars', $filename, 'public');

        $avatarUrl = Storage::disk('public')->url($path);
        
        // Update profile with new avatar path first
        $profile->update(['avatar_path' => $avatarUrl]);
        
        // Then delete old avatar file (only if it's different from the new one)
        if ($oldAvatarPath && $oldAvatarPath !== $avatarUrl) {
            $this->deleteAvatarFileByPath($oldAvatarPath);
        }

        return response()->json([
            'message' => 'Avatar uploaded successfully',
            'avatar_path' => $avatarUrl,
        ]);
    }

    public function deleteAvatar(): JsonResponse
    {
        $profile = Profile::firstOrFail();

        $this->deleteAvatarFile($profile);
        $profile->update(['avatar_path' => null]);

        return response()->json(['message' => 'Avatar deleted successfully']);
    }

    private function deleteResumeFile(Profile $profile): void
    {
        if (!$profile->resume_url) {
            return;
        }

        $path = str_replace('/storage/', '', parse_url($profile->resume_url, PHP_URL_PATH));

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function deleteAvatarFile(Profile $profile): void
    {
        if (!$profile->avatar_path) {
            return;
        }

        $this->deleteAvatarFileByPath($profile->avatar_path);
    }

    private function deleteAvatarFileByPath(string $avatarPath): void
    {
        // Extract path from URL - same method as ProjectController
        $path = str_replace('/storage/', '', parse_url($avatarPath, PHP_URL_PATH));
        
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
