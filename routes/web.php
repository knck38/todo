<?php

use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [TaskController::class, 'index'])->name('index');
Route::resource('/task', TaskController::class)->except(['index']);

require __DIR__.'/auth.php';
