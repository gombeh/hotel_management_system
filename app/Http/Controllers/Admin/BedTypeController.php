<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BedType\CreateRequest;
use App\Http\Requests\Admin\BedType\EditRequest;
use App\Http\Resources\BedTypeResource;
use App\Models\BedType;

class BedTypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BedType::class, 'bedType');
    }

    public function index()
    {
        $user = auth()->user();
        $bedTypes = BedType::latest()->get()->map(fn($bedType) => $bedType->setAttribute('can', [
            'edit' => $user->can('update', $bedType),
            'delete' => $user->can('delete', $bedType),
        ]));

        return inertia("Admin/BedType/List", [
            'bedTypes' => BedTypeResource::collection($bedTypes),
            'can' => [
                'create' => $user->can('create', BedType::class),
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        BedType::create($data);

        return redirect()->back()->with('message', 'Bed Type created.');
    }

    public function update(EditRequest $request, BedType $bedType)
    {
        $data = $request->validated();

        $bedType->update($data);

        return redirect()->back()->with('message', 'Bed Type updated.');
    }


    public function destroy(BedType $bedType)
    {
        $bedType->delete();

        return redirect()->back()->with('message', 'Bed Type deleted.');
    }
}
