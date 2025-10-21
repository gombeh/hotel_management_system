<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with('media')
            ->active()
            ->limit(8)
            ->latest()
            ->paginate();

        return inertia('Landing/RoomType/List',[
            'roomTypes' => RoomTypeResource::collection($roomTypes),
        ]);
    }

    public function show(RoomType $roomType)
    {
        $roomType->load('bedTypes', 'media');
        return inertia('Landing/RoomType/Show',[
            'roomType' => RoomTypeResource::make($roomType),
        ]);
    }
}
