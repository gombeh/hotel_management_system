<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

        $hasNeedSortFiles = array_some($files, fn($file) => is_integer($file));

        $sortedIds = array_map(function ($file) use ($hasDeleteAllFiles, $collectionName, $model, &$hasDeletedFiles) {

            if (!is_string($file)) {
                return $file;
            }

            if ($hasDeleteAllFiles && !$hasDeletedFiles) {
                $model->getMedia($collectionName)->each(fn($media) => $model->deleteMedia($media->id));
                $hasDeletedFiles = true;
            }

            $path = Storage::path($file);

            if (!file_exists($path)) {
                return null;
            }

            $media = $model->addMedia($path)->toMediaCollection($collectionName);
            return $media->id;
        }, $files);

        $hasNeedSortFiles && Media::setNewOrder($sortedIds);
    }
}
