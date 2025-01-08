<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_name',
        'size',
        'extension',
        'path',
        'is_image',
        'is_video', // Булевое поле для видеофайлов
        'is_audio', // Булевое поле для аудиофайлов
        'is_document', // Булевое поле для документов
    ];
}

