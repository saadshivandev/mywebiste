<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'Laravel', 'category' => 'Backend', 'level' => 90],
            ['name' => 'Vue 3', 'category' => 'Frontend', 'level' => 88],
            ['name' => 'Node.js (basics)', 'category' => 'Backend', 'level' => 60],
            ['name' => 'React (basics)', 'category' => 'Frontend', 'level' => 55],
            ['name' => 'Docker', 'category' => 'DevOps', 'level' => 70],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'level' => 85],
            ['name' => 'HTML & CSS', 'category' => 'Frontend', 'level' => 90],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'level' => 85],
            ['name' => 'Git', 'category' => 'DevOps', 'level' => 85],
            ['name' => 'GitHub', 'category' => 'DevOps', 'level' => 85],
            ['name' =>"Cursor", 'category' => 'AI', 'level' => 90],
            ['name' =>'Antigravity', 'category' => 'AI', 'level' => 90],
        ];

        foreach ($skills as $index => $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                [
                    'category' => $skill['category'],
                    'level' => $skill['level'],
                    'order' => $index + 1,
                ]
            );
        }
    }
}


