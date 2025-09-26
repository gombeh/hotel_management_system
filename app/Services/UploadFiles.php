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
            $isNew = $file['new'] ?? null;
            $path = $file['id'] ?? null;
            $url = $file['url'] ?? null;

            if (!$url || !$path || !$isNew) {
                continue;
            }

            if ($hasDeleteAllFiles && !$hasDeletedFiles) {
                $model->media->each(fn($media) => $model->deleteMedia($media->id));
                $hasDeletedFiles = true;
            }

            $path = Storage::path($path);
            $model->addMedia($path)->toMediaCollection($collectionName);
        }
    }
}
