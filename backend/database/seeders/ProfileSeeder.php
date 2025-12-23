<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['email' => 'saadshivantech@gmail.com'],
            [
                'name' => 'Saad Shivan Tech',
                'role' => 'Full Stack Developer',
                'headline' => 'Full stack Laravel & Vue.js developer crafting fast, modern web experiences.',
                'bio' => 'I am a full stack web developer focused on building robust backends with Laravel and elegant frontends with Vue.js. I also work with Node.js, React, Docker, HTML, JavaScript, CSS, and Tailwind CSS to deliver modern, maintainable applications.',
                'languages' => 'Kurdish (native), Arabic, English, Dutch',
                'location' => 'Remote',
                'avatar_path' => null,
                'resume_url' => null,
                'social_links' => json_encode([
                    'github' => 'https://github.com/saadshivandev',
                    'linkedin' => 'https://www.linkedin.com/in/saadshivantech',
                ]),
            ]
        );
    }
}


