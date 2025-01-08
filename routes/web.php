<?php

use Illuminate\Support\Facades\Route;

// Главная страница для Vue.js
Route::get('/{any}', function () {
    return view('index'); // Убедись, что файл resources/views/index.blade.php существует
})->where('any', '.*');

