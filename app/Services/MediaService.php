<?php

namespace App\Services;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class MediaService
{
    public static function resource(JsonResource $model, string $collection = 'default'): AnonymousResourceCollection|array|null
    {
        if (!$model->relationLoaded('media')) return null;

        return $model->hasMedia($collection)
            ? MediaResource::collection($model->getMedia($collection))
            : [
                [
                    'id' => null,
                    'url' => $model->getFirstMediaUrl($collection),
                ]
            ];
    }
}
