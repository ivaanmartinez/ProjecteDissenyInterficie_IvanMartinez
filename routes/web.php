<?php

use App\Http\Controllers\Api\VideosAPIController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SeriesManageController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManageController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

Route::middleware(['auth', 'can:manage users'])->group(function () {
    Route::get('/users/manage', [UserManageController::class, 'index'])->name('users.manage.index');
    Route::get('/users/manage/create', [UserManageController::class, 'create'])->name('users.manage.create');
    Route::post('/users/manage', [UserManageController::class, 'store'])->name('users.manage.store');
    Route::get('/users/manage/{user}/edit', [UserManageController::class, 'edit'])->name('users.manage.edit');
    Route::put('/users/manage/{user}', [UserManageController::class, 'update'])->name('users.manage.update');
    Route::delete('/users/manage/{user}', [UserManageController::class, 'destroy'])->name('users.manage.destroy');
});


Route::get('/video/{id}', [VideosController::class, 'show'])->name('videos.show');
Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');

Route::middleware(['auth', 'can:manage videos'])->group(function () {
    Route::get('/videos/store', [VideosController::class, 'store'])->name('videos.store');
    Route::get('/videos/create', [VideosController::class, 'create'])->name('videos.create');
    Route::get('/videos/{id}/edit', [VideosController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{id}', [VideosController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{id}', [VideosController::class, 'destroy'])->name('videos.destroy');
    Route::get('/videos/manage', [VideosManageController::class, 'index'])->name('videos.manage.index');
    Route::get('/videos/manage/create', [VideosManageController::class, 'create'])->name('videos.manage.create');
    Route::post('/videos/manage', [VideosManageController::class, 'store'])->name('videos.manage.store');
    Route::get('/videos/manage/{id}/edit', [VideosManageController::class, 'edit'])->name('videos.manage.edit');
    Route::put('/videos/manage/{id}', [VideosManageController::class, 'update'])->name('videos.manage.update');
    Route::delete('/videos/manage/{id}', [VideosManageController::class, 'destroy'])->name('videos.manage.destroy');
});

Route::middleware(['auth', 'can:manage series'])->prefix('series/manage')->group(function () {
    Route::get('/', [SeriesManageController::class, 'index'])->name('series.manage.index');
    Route::get('/create', [SeriesManageController::class, 'create'])->name('series.manage.create');
    Route::post('/', [SeriesManageController::class, 'store'])->name('series.manage.store');
    Route::get('/{serie}/edit', [SeriesManageController::class, 'edit'])->name('series.manage.edit');
    Route::put('/{serie}', [SeriesManageController::class, 'update'])->name('series.manage.update');
    Route::delete('/{serie}', [SeriesManageController::class, 'destroy'])->name('series.manage.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/serie/{id}', [SeriesController::class, 'show'])->name('series.show');
    Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::post('/series', [SeriesController::class, 'store'])->name('series.store');
});
Route::get('/notifications', function () {
    return view('notifications');
});
//Logout
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
