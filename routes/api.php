<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('authors')->group(function () {
    Route::post('/', [AuthorController::class, 'store']);
    Route::delete('/{author}', [AuthorController::class, 'destroy']);
    Route::get('/', [AuthorController::class, 'index']);
    Route::get('/{author}', [AuthorController::class, 'show']);
});

Route::prefix('books')->group(function () {
    Route::post('/', [BookController::class, 'store']);
    Route::delete('/{book}', [BookController::class, 'destroy']);
        Route::get('/{page}/{limit}', [BookController::class, 'index']);
    Route::get('/{book}', [BookController::class, 'show']);
});
