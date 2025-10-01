<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomType\CreateRequest;
use App\Http\Requests\Admin\RoomType\EditRequest;
use App\Http\Resources\BedTypeResource;
use App\Http\Resources\RoomTypeResource;
use App\Models\BedType;
use App\Models\Facility;
use App\Models\RoomType;
use App\Services\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit');

        $user = auth()->user();
        $roomTypes = QueryBuilder::for(RoomType::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name', 'size', 'max_total_guests', 'price', 'status'])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($roomType) => $roomType->setAttribute('can', [
                'edit' => auth()->user()->can('update', $user),
                'delete' => auth()->user()->can('delete', $user),
            ]));

        $resource = RoomTypeResource::collection($roomTypes);
        return inertia('Admin/RoomType/List', [
            'roomTypes' => $resource,
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
            'can' => [
                'createRoomType' => auth()->user()->can('create', RoomType::class),
            ]
        ]);
    }

    public function create()
    {
        $bedTypes = BedType::all();
        $facilities = Facility::all()->pluck('name', 'id');

        return inertia('Admin/RoomType/Create', [
            'bedTypes' => BedTypeResource::collection($bedTypes),
            'facilities' => $facilities,
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
        $bedTypes = BedType::all();
        $facilities = Facility::all()->pluck('name', 'id');

        return inertia('Admin/RoomType/Update', [
            'roomType' => new RoomTypeResource($roomType),
            'bedTypes' => BedTypeResource::collection($bedTypes),
            'facilities' => $facilities,
        ]);
    }

    public function update(Request $request, RoomType $roomType)
    {
        //
    }

    public function destroy(RoomType $roomType)
    {
        //
    }
}
