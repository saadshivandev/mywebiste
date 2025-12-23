<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;

class ExportProjectsToSeeder extends Command
{
    protected $signature = 'projects:export-seeder';
    protected $description = 'Export projects from database to seeder format';

    public function handle()
    {
        $projects = Project::orderBy('order')->get();
        
        if ($projects->isEmpty()) {
            $this->warn('No projects found in database.');
            return 0;
        }
        
        // Build the array content
        $arrayContent = '';
        
        foreach ($projects as $project) {
            $arrayContent .= "            [\n";
            $arrayContent .= "                'title' => " . var_export($project->title, true) . ",\n";
            $arrayContent .= "                'short_description' => " . var_export($project->short_description, true) . ",\n";
            $arrayContent .= "                'tech_stack' => " . var_export($project->tech_stack, true) . ",\n";
            $arrayContent .= "                'category' => " . var_export($project->category, true) . ",\n";
            $arrayContent .= "                'github_url' => " . var_export($project->github_url, true) . ",\n";
            $arrayContent .= "                'live_url' => " . ($project->live_url ? var_export($project->live_url, true) : 'null') . ",\n";
            $arrayContent .= "                'is_featured' => " . ($project->is_featured ? 'true' : 'false') . ",\n";
            
            // Handle thumbnail_path
            if ($project->thumbnail_path) {
                $thumbnailPath = $project->thumbnail_path;
                // Remove full URLs, keep only relative path
                if (strpos($thumbnailPath, '/storage/') !== false) {
                    $thumbnailPath = preg_replace('#https?://[^/]+/storage/#', '', $thumbnailPath);
                }
                $arrayContent .= "                'thumbnail_path' => " . var_export($thumbnailPath, true) . ",\n";
            } else {
                $arrayContent .= "                'thumbnail_path' => null,\n";
            }
            
            // Handle images array
            if ($project->images && is_array($project->images) && count($project->images) > 0) {
                $imagePaths = [];
                foreach ($project->images as $imageUrl) {
                    $imagePath = $imageUrl;
                    // Remove full URLs, keep only relative path
                    if (strpos($imagePath, '/storage/') !== false) {
                        $imagePath = preg_replace('#https?://[^/]+/storage/#', '', $imagePath);
                    }
                    $imagePaths[] = $imagePath;
                }
                // Format as array syntax
                $imagesString = "['" . implode("', '", $imagePaths) . "']";
                $arrayContent .= "                'images' => " . $imagesString . ",\n";
            } else {
                $arrayContent .= "                'images' => null,\n";
            }
            
            $arrayContent .= "            ],\n";
        }
        
        // Read the current seeder file
        $seederFile = database_path('seeders/ProjectSeeder.php');
        $currentContent = file_get_contents($seederFile);
        
        // Find and replace the $projects array content (between [ and ];)
        // Match: $projects = [ ... content ... ]; (before foreach)
        $pattern = '/(\$projects = \[)(.*?)(\n        \];)/s';
        
        if (preg_match($pattern, $currentContent)) {
            $replacement = '$1' . "\n" . $arrayContent . '        $3';
            $newContent = preg_replace($pattern, $replacement, $currentContent);
            
            file_put_contents($seederFile, $newContent);
            $this->info("✅ Seeder file updated successfully!");
            $this->info("Updated " . $projects->count() . " projects with their image paths.");
        } else {
            $this->error("Could not find \$projects array in seeder file.");
            $this->info("Array content that should be inserted:");
            $this->line($arrayContent);
        }
        
        return 0;
    }
}
