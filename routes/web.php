<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');

    // Projects CRUD
    Route::resource('projects', ProjectController::class);

    // Tasks CRUD nested in projects (gunakan resource agar nama routenya konsisten)
    Route::resource('projects.tasks', TaskController::class);
   Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');


    // Team management
    Route::get('/team', [UserController::class, 'index'])->name('team.index');
    Route::get('/team/{user}', [UserController::class, 'show'])->name('team.show');

    // Tambah/Hapus anggota team ke proyek
    Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMember'])->name('projects.add-member');
    Route::delete('/projects/{project}/remove-member/{user}', [ProjectController::class, 'removeMember'])->name('projects.remove-member');

    // Profile (default dari Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth'])->group(function () {
    Route::resource('projects.tasks', TaskController::class)->except(['show']);
});
   Route::put('/projects/{project}/tasks/{task}/status', [TaskController::class, 'updateStatus'])
    ->name('projects.tasks.updateStatus');


});

require __DIR__.'/auth.php';
