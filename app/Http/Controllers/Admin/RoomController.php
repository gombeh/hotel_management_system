<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoomStatus;
use App\Enums\SmokingPreference;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Room\CreateRequest;
use App\Http\Requests\Admin\Room\EditRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\Sorts\RelatedSort;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }


    public function index(Request $request)
    {
        $limit = $request->limit;
        $user = auth()->user();
        $countries = QueryBuilder::for(Room::class)
            ->with('type')
            ->allowedFilters([
                AllowedFilter::exact('room_number'),
                AllowedFilter::exact('floor_number'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('smoking_preference'),
                AllowedFilter::exact('room_type_id'),
            ])->allowedSorts([
                'room_number',
                'floor_number',
                'status',
                AllowedSort::custom('type.name', new RelatedSort),
                'smoking_preference'
            ])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($room) => $room->setAttribute('can', [
                'edit' => $user->can('update', $room),
                'delete' => $user->can('delete', $room),
            ]));

        $roomTypes = RoomType::all()->pluck('name', 'id');
        $resource = RoomResource::collection($countries);

        return inertia('Admin/Room/List', [
            'roomTypes' => $roomTypes,
            'rooms' => $resource,
            'statuses' => RoomStatus::asSelect(),
            'smokingPreferences' => SmokingPreference::asSelect(),
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
            'can' => [
                'createRoom' => $user->can('create', Room::class),
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        Room::create($data);

        return redirect()->back()->with('message', 'Room created.');
    }


    public function update(EditRequest $request, Room $room)
    {
        $data = $request->validated();

        $room->update($data);

        return redirect()->back()->with('message', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->back()->with('message', 'Room deleted.');
    }
}
