<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;


Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/projects/store', [TaskController::class, 'storeProject'])->name('projects.store');

//task routes
Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/store', [TaskController::class, 'storeTask'])->name('tasks.store');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/{task}/update', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
});
