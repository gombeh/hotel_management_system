<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $files = $request->allFiles();

        $urls = [];

        foreach ($files as $file) {
            $urls[] = Storage::url($file->storeAs('temp', $file->getClientOriginalName()));
        }

        return response()->json([
            'files' => $urls,
        ]);
    }
}
