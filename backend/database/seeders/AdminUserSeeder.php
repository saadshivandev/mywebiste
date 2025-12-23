<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'saadshivantech@gmail.com'],
            [
                'name' => 'Saad Shivan Tech',
                'password' => 'Homeisland12',
            ]
        );
    }
}


