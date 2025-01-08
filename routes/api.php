<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


Route::middleware('api')->group(function () {
    // Список файлов с пагинацией и поиском
    Route::get('/files', [FileController::class, 'index']);

    // Загрузка нового файла
    Route::post('/files', [FileController::class, 'store']);

    // Получение информации о конкретном файле
    Route::get('/files/{file}', [FileController::class, 'show']);

    // Обновление информации о файле или загрузка нового файла
    Route::put('/files/{id}', [FilesController::class, 'update']);

    // Удаление файла
    Route::delete('/files/{file}', [FileController::class, 'destroy']);

});
