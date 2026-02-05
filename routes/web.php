<?php

use App\Http\Controllers\TaskController;

Route::get('/', fn() => redirect('/tasks'));
Route::resource('tasks', TaskController::class)->only(['index','store','update','destroy']);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');