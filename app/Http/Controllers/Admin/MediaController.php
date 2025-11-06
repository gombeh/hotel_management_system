<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $data = $request->validate([
            'imageFilepond' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
        ]);
        $file = $data['imageFilepond'];

        $filename = Str::random(40) . '.' . $file->extension();

        $path = $file->storeAs('temp', $filename);
        $data = [
            'url' => Storage::url($path),
            'path' => $path
        ];

        return response()->json([
            'file' => $data,
        ]);
    }

    public function delete(Media $media)
    {
        $media->model->deleteMedia($media->id);
    }
}
