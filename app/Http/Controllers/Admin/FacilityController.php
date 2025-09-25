<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Facility::class, 'facility');
    }

    public function index()
    {
        $user = auth()->user();
        $facility = Facility::latest()->get()->map(fn($facility) => $facility->setAttribute('can', [
            'edit' => $user->can('update', $facility),
            'delete' => $user->can('delete', $facility),
        ]));

        return inertia("Admin/Facility/List", [
            'facilities' => FacilityResource::collection($facility),
            'can' => [
                'create' => $user->can('create', Facility::class),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:facilities,name',
            'icon' => 'nullable|string',
        ]);

        $facility = Facility::create($data);

        if($data['icon']) {
            $facility->addMedia($data['icon'])->toMediaCollection();
        }

        return redirect()->back()->with('message', 'Facility created.');
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:facilities,name,' . $facility->id,
        ]);

        $facility = $facility->update($data);

        if($data['icon']) {
            $facility->media->each(fn($media) => $facility->deleteMedia($media->id));
            $facility->addMedia($data['icon'])->toMediaCollection();
        }

        return redirect()->back()->with('message', 'Facility updated.');
    }


    public function destroy(Facility $facility)
    {
        $facility->delete();

        return redirect()->back()->with('message', 'Facility deleted.');
    }
}
