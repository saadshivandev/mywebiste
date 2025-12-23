<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/profile', [ProfileController::class, 'show']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/skills', [SkillController::class, 'index']);

Route::post('/contact', [ContactMessageController::class, 'store']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/profile/resume', [ProfileController::class, 'uploadResume']);
        Route::delete('/profile/resume', [ProfileController::class, 'deleteResume']);
        Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar']);
        Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar']);

        Route::get('/services', [ServiceController::class, 'index']);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::put('/services/{service}', [ServiceController::class, 'update']);
        Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
        Route::post('/projects/images', [ProjectController::class, 'uploadImages']);
        Route::delete('/projects/images', [ProjectController::class, 'deleteImage']);

        Route::get('/skills', [SkillController::class, 'index']);
        Route::post('/skills', [SkillController::class, 'store']);
        Route::put('/skills/{skill}', [SkillController::class, 'update']);
        Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);

        Route::get('/contacts', [ContactMessageController::class, 'index']);
        Route::patch('/contacts/{contact}', [ContactMessageController::class, 'updateStatus']);
    });
});

