<?php

namespace App\Http\Controllers\Landing;

use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class RoomTypeController extends Controller
{
    public function index()
    {
        $filters = (array) request()->input('filters', []);

        if(keys_not_null(['check_in', 'check_out', 'rooms', 'adults', 'children'], $filters)) {
            $roomTypes = RoomType::with('media')->has('rooms', '>=', $filters['rooms'])
                ->whereHas('rooms', function (Builder $query) use ($filters) {
                    $query->whereNot('status', RoomStatus::Maintenance)
                        ->whereDoesntHave(
                            'bookings',
                            fn(Builder $q) => $q->activeOverlap($filters['check_in'], $filters['check_out'])
                        );
                })->active()
                ->capacity($filters['adults'], $filters['children'])
                ->latest()
                ->paginate(9);
        } else {
            $roomTypes = RoomType::with('media')
                ->active()
                ->latest()
                ->paginate(9);
        }


        return inertia('Landing/RoomType/List', [
            'roomTypes' => Inertia::scroll(fn() => RoomTypeResource::collection($roomTypes)),
            'filters' => (object)$filters,
        ]);
    }

    public function show(RoomType $roomType)
    {
        $roomType->load('bedTypes', 'media', 'facilities');
        return inertia('Landing/RoomType/Show', [
            'roomType' => RoomTypeResource::make($roomType),
            'filters' => (object)request()->input('filters', []),
        ]);
    }
}
