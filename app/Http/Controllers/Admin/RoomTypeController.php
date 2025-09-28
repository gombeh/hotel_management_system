<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use Illuminate\Http\Request;
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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(RoomType $roomType)
    {
        //
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
