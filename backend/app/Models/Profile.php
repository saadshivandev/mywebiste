<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'role',
        'headline',
        'bio',
        'location',
        'email',
        'avatar_path',
        'resume_url',
        'social_links',
        'languages',
    ];
}
