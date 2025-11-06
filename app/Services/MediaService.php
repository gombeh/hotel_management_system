<?php

namespace App\Services;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService
{
    public static function resource(JsonResource $model, string $collection = 'default'): AnonymousResourceCollection|array|null
    {
        if (!$model->relationLoaded('media')) return null;

        if ($model->hasMedia($collection)) {
            return MediaResource::collection($model->getMedia($collection)->map(function (Media $media) use ($collection) {
                $conversions = $media->getGeneratedConversions()->keys()->mapWithKeys(fn(string $conversion) => [
                    $conversion => $media->getUrl($conversion)
                ]);
                $media->setAttribute('conversions', $conversions);
                return $media;
            }));
        }
        return [
            [
                'id' => null,
                'url' => $model->getFirstMediaUrl($collection),
            ]
        ];
    }
}
