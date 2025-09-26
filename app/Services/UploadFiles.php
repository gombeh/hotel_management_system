<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadFiles
{
    public static function handle(
        Model  $model,
        array  $files,
        string $collectionName = 'default',
        bool   $hasDeleteAllFiles = false
    ): void
    {
        $hasDeletedFiles = false;
        foreach ($files as $file) {

            if(!is_string($file)) {
                continue;
            }

            if ($hasDeleteAllFiles && !$hasDeletedFiles) {
                $model->media->each(fn($media) => $model->deleteMedia($media->id));
                $hasDeletedFiles = true;
            }

            $path = Storage::path($file);

            if(!file_exists($path)) {
                continue;
            }
            $model->addMedia($path)->toMediaCollection($collectionName);
        }
    }
}
