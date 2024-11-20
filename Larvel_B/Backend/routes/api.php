<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TaskController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    // Authentication Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api');

    Route::middleware('auth')->group(function () {
        // Web routes
        Route::get('/', [TaskController::class, 'index'])->name('task.index');
        Route::get('/create', function () { return view('create'); })->name('task.create');
        Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
        Route::post('/store', [TaskController::class, 'store'])->name('task.store');
        Route::put('/update/{task}', [TaskController::class, 'update'])->name('task.update');
        Route::get('/delete/{task}', [TaskController::class, 'delete'])->name('task.delete');
    });
    
    Route::middleware('auth:api')->group(function () {
        Route::get('/tasks', [TaskController::class, 'index']);
        Route::post('/tasks', [TaskController::class, 'store']);
        Route::put('/tasks/{id}', [TaskController::class, 'update']);
        Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    });
    
});
