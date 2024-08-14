<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('books/books');
});

Route::get('/books/store', function () {
    return view('books/store');
});

