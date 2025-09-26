<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $data = $request->validate([
            'imageFilepond' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $file = $data['imageFilepond'];

        $path = $file->storeAs('temp', $file->getClientOriginalName());
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
