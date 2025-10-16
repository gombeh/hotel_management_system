<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoomTypeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomType\CreateRequest;
use App\Http\Requests\Admin\RoomType\EditRequest;
use App\Http\Resources\RoomTypeResource;
use App\Models\BedType;
use App\Models\Facility;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoomTypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(RoomType::class, 'roomType');
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit');

        $user = auth()->user();
        $roomTypes = QueryBuilder::for(RoomType::class)
            ->withCount('rooms')
            ->allowedFilters(['name', AllowedFilter::exact('status')])
            ->allowedSorts(['name', 'size', 'max_total_guests', 'price', 'status'])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($roomType) => $roomType->setAttribute('access', [
                'edit' => $user->can('update', $roomType),
                'delete' => $user->can('delete', $roomType),
            ]));

        return inertia('Admin/RoomType/List', [
            'roomTypes' => RoomTypeResource::collection($roomTypes),
            'statuses' => RoomTypeStatus::asSelect(),
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
            'access' => [
                'createRoomType' => $user->can('create', RoomType::class),
                'viewRooms' => $user->can('viewAny', Room::class),
            ]
        ]);
    }

    public function create()
    {
        $bedTypes = BedType::all()->pluck('name', 'id');
        $facilities = Facility::all()->pluck('name', 'id');

        return inertia('Admin/RoomType/Create', [
            'bedTypes' => $bedTypes,
            'facilities' => $facilities,
            'statuses' => RoomTypeStatus::asSelect(),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function() use ($data) {
            $roomType = RoomType::create($data);
            UploadFiles::handle($roomType, $data['mainImage'], 'main', true);
            UploadFiles::handle($roomType, $data['gallery'], 'gallery');

            $bedTypes = collect($data['bedTypes'])->mapWithKeys(function($bedType) {
                return [$bedType['id'] => ['quantity' => $bedType['quantity']]];
            });

            $roomType->facilities()->sync($data['facilities']);
            $roomType->bedTypes()->sync($bedTypes);
        });

        return redirect()->route('admin.roomTypes.create')->with('message', 'Room type created.');
    }

    public function edit(RoomType $roomType)
    {
        $roomType->load('facilities', 'bedTypes');
        $bedTypes = BedType::all()->pluck('name', 'id');
        $facilities = Facility::all()->pluck('name', 'id');

        return inertia('Admin/RoomType/Update', [
            'roomType' => new RoomTypeResource($roomType),
            'bedTypes' => $bedTypes,
            'facilities' => $facilities,
            'statuses' => RoomTypeStatus::asSelect(),
        ]);
    }

    public function update(EditRequest $request, RoomType $roomType)
    {
        $data = $request->validated();

        DB::transaction(function() use ($roomType, $data) {
            $roomType->update($data);
            UploadFiles::handle($roomType, $data['mainImage'], 'main', true);
            UploadFiles::handle($roomType, $data['gallery'], 'gallery');

            $bedTypes = collect($data['bedTypes'])->mapWithKeys(function($bedType) {
                return [$bedType['id'] => ['quantity' => $bedType['quantity']]];
            });

            $roomType->facilities()->sync($data['facilities']);
            $roomType->bedTypes()->sync($bedTypes);
        });

        return redirect()->back()->with('message', 'Room type updated.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->back()->with('message', 'Room type deleted.');
    }
}
