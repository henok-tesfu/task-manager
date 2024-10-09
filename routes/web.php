<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;


Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/projects/store', [TaskController::class, 'storeProject'])->name('projects.store');
Route::post('/tasks/store', [TaskController::class, 'storeTask'])->name('tasks.store');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
