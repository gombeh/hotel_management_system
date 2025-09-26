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
        $files = $request->allFiles();

        $urls = [];

        foreach ($files as $file) {
            $file = $file->storeAs('temp', $file->getClientOriginalName());
            $urls[] = [
                'url' => Storage::url($file),
                'path' => $file
            ];
        }

        return response()->json([
            'files' => $urls,
        ]);
    }

    public function delete(Media $media)
    {
        $media->model->deleteMedia($media->id);
    }
}
