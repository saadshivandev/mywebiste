<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Dice Challenge',
                'short_description' => 'A simple, interactive game where two players roll a pair of dice to see who wins.',
                'tech_stack' => 'HTML ,CSS ,JavaScript',
                'category' => 'frontend',
                'github_url' => 'https://github.com/saadshivandev/Dice-Challenge',
                'live_url' => 'https://saadshivandev.github.io/Dice-Challenge/',
                'is_featured' => false,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949d375dd537_1766445941.PNG'],
            ],
            [
                'title' => 'Todo App',
                'short_description' => 'A note-taking application for managing your daily tasks, allowing you to easily add and delete notes.  React',
                'tech_stack' => 'React',
                'category' => 'frontend',
                'github_url' => 'https://github.com/saadshivandev/Todo-app',
                'live_url' => 'https://todo-app-nine-black-35.vercel.app/',
                'is_featured' => false,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949d3f7cad0e_1766446071.PNG'],
            ],
            [
                'title' => 'Book Library',
                'short_description' => 'A Laravel web app for managing a personal book collection with authentication, categories, and full CRUD features. Tailwind CSS provides a clean, responsive UI while Laravel handles backend logic and database operations.',
                'tech_stack' => 'Laravel ,Tailwind CSS',
                'category' => 'fullstack',
                'github_url' => 'https://github.com/saadshivandev/Book-Library-main',
                'live_url' => null,
                'is_featured' => false,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949d97a7011f_1766447482.png'],
            ],
            [
                'title' => 'Job-Board',
                'short_description' => 'A lightweight Laravel blogging platform with post creation, comments, and full CRUD features. Designed as a simple content board, it’s great for learning Laravel basics and building an interactive, minimal content‑sharing app.',
                'tech_stack' => 'Laravel Tailwind',
                'category' => 'fullstack',
                'github_url' => 'https://github.com/saadshivandev/JOB-BOARD',
                'live_url' => null,
                'is_featured' => false,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949da39b5785_1766447673.png'],
            ],
            [
                'title' => 'T-Shirt Store',
                'short_description' => 'E‑commerce site for custom T‑shirts with a product catalog, cart, checkout, and admin panel. I built full product CRUD, cart and order flows, and a responsive Tailwind CSS UI, resulting in a clean, maintainable codebase for fast updates.',
                'tech_stack' => 'Laravel, Tailwind CSS',
                'category' => 'fullstack',
                'github_url' => 'https://github.com/saadshivandev/t-shirt-store',
                'live_url' => null,
                'is_featured' => false,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949dc4d0208e_1766448205.png'],
            ],
            [
                'title' => 'Cleaning Website',
                'short_description' => 'A Dutch cleaning‑service platform with a booking flow, admin dashboard, and fully responsive design. I built Vue.js  components, Laravel APIs, and optimized MySQL, resulting in smoother service management and reduced manual workload.',
                'tech_stack' => 'Laravel, Vue.js, MySQL, REST API',
                'category' => 'fullstack',
                'github_url' => 'https://github.com/saadshivandev/cleaning',
                'live_url' => null,
                'is_featured' => false,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949e15b37775_1766449499.png'],
            ],
            [
                'title' => 'Play Drum',
                'short_description' => 'An interactive web app that lets you make drum sounds by pressing keys on your keyboard.',
                'tech_stack' => 'HTML, CSS, JavaScript',
                'category' => 'frontend',
                'github_url' => 'https://github.com/saadshivandev/Drum',
                'live_url' => 'https://saadshivandev.github.io/Drum/',
                'is_featured' => true,
                'thumbnail_path' => null,
                'images' => ['projects/project_6949d15d72b24_1766445405.png'],
            ],
        
        ];



        foreach ($projects as $index => $project) {
            Project::updateOrCreate(
                ['slug' => Str::slug($project['title'])],
                [
                    'title' => $project['title'],
                    'short_description' => $project['short_description'],
                    'tech_stack' => $project['tech_stack'],
                    'category' => $project['category'],
                    'github_url' => $project['github_url'],
                    'live_url' => $project['live_url'],
                    'is_featured' => $project['is_featured'],
                    'thumbnail_path' => $project['thumbnail_path'],
                    'images' => $project['images'],
                    'order' => $index + 1,
                ]
            );
        }
    }
}


