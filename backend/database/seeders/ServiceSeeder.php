<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Fast',
                'subtitle' => 'Performance-focused builds',
                'description' => 'Optimized Laravel and Vue.js applications with fast load times, clean queries, and efficient assets.',
                'icon' => 'speed',
            ],
            [
                'title' => 'Responsive',
                'subtitle' => 'Looks great on any device',
                'description' => 'Carefully crafted responsive layouts that adapt perfectly from mobile to large desktop screens.',
                'icon' => 'devices',
            ],
            [
                'title' => 'Intuitive',
                'subtitle' => 'User-centered experiences',
                'description' => 'Clear UX flows and interfaces that make complex actions feel simple and natural.',
                'icon' => 'bulb',
            ],
            [
                'title' => 'Dynamic',
                'subtitle' => 'Interactive frontends',
                'description' => 'Live dashboards, animations, and dynamic components powered by Vue and modern JavaScript.',
                'icon' => 'reactive',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                [
                    'title' => $service['title'],
                    'subtitle' => $service['subtitle'],
                    'description' => $service['description'],
                    'icon' => $service['icon'],
                    'order' => $index + 1,
                ]
            );
        }
    }
}


