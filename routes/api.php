<?php

use App\Http\Controllers\Api\{
    CourseController,
    LessonController,
    ModuleController,
    ReplySupportController,
    SupportController
};
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function() {
    return response()->json(['error' => 'Unauthorized'], 400);
})->name('login');
Route::post('/login', [AuthController::class, 'auth']);
Route::post('/forgot/password', [ResetPasswordController::class, 'sendResetLink']);
Route::post('/reset/password', [ResetPasswordController::class, 'resetPassword']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);
    Route::get('/courses/{id}/module', [ModuleController::class, 'index']);
    Route::get('/modules/{id}/lessons', [LessonController::class, 'index']);
    Route::get('/lessons/{id}', [LessonController::class, 'show']);
    Route::get('/lesson/viewed', [LessonController::class, 'checkLessonViewed']);
    Route::get('/supports', [SupportController::class, 'index']);
    Route::post('/supports', [SupportController::class, 'store']);
    Route::post('/supports/replies', [ReplySupportController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
