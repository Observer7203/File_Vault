<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('original_name', 'like', '%' . $request->search . '%');
        }

        $files = $query->paginate(50);

        return response()->json($files);
    }

   

    
public function show(File $file)
{
    if (!$file) {
        return response()->json(['error' => 'File not found'], 404);
    }

    return response()->json($file);
}


public function store(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:jpeg,png,jpg,gif,svg,doc,docx,pdf,xls,xlsx,mp3,mp4,avi,mkv,wav,zip,rar|max:8192',
        'name' => 'nullable|string|max:5000',
    ]);

    $file = $request->file('file');
    $path = $file->store('uploads', 'public');
    $mimeType = $file->getMimeType();

    $isImage = str_contains($mimeType, 'image');
    $isVideo = str_contains($mimeType, 'video');
    $isAudio = str_contains($mimeType, 'audio');
    $isDocument = str_contains($mimeType, 'application') || str_contains($mimeType, 'text');

    $newFile = File::create([
        'name' => $request->name ?? $file->getClientOriginalName(),
        'original_name' => $file->getClientOriginalName(),
        'size' => $file->getSize(),
        'extension' => $file->getClientOriginalExtension(),
        'path' => $path,
        'is_image' => $isImage,
        'is_video' => $isVideo,
        'is_audio' => $isAudio,
        'is_document' => $isDocument,
    ]);

    return response()->json($newFile, 201);
}



public function update(Request $request, $id)
{
    // Ищем файл по ID
    $file = File::findOrFail($id);

    // Логируем входные данные
    \Log::info('Request data: ', $request->all());

    // Обновляем только имя файла
    $file->update([
        'name' => $request->input('name') ?? $file->name,
    ]);

    return response()->json([
        'message' => 'Имя файла обновлено успешно.',
        'file' => $file,
    ]);
}



public function destroy($id)
{
    $file = File::find($id);

    if (!$file) {
        return response()->json(['error' => 'File not found'], 404);
    }

    if (Storage::disk('public')->exists($file->path)) {
        Storage::disk('public')->delete($file->path);
    }

    $file->delete();

    return response()->json(['message' => 'File deleted successfully.']);
}


}
