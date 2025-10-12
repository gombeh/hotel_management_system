<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CancellationRule\CreateRequest;
use App\Http\Requests\Admin\CancellationRule\EditRequest;
use App\Http\Resources\CancelRuleResource;
use App\Models\CancellationRule;

class CancellationRuleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(CancellationRule::class, 'cancellationRule');
    }

    public function index()
    {
        $user = auth()->user();
        $cancellationRules = CancellationRule::latest()->get()->map(fn($cancellationRule) => $cancellationRule->setAttribute('can', [
            'edit' => $user->can('update', $cancellationRule),
            'delete' => $user->can('delete', $cancellationRule),
        ]));

        return inertia("Admin/CancellationRule/List", [
            'cancellationRules' => CancelRuleResource::collection($cancellationRules),
            'can' => [
                'create' => $user->can('create', CancellationRule::class),
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        CancellationRule::create($data);

        return redirect()->back()->with('message', 'Cancellation Rule created.');
    }

    public function update(EditRequest $request, CancellationRule $cancellationRule)
    {
        $data = $request->validated();

        $cancellationRule->update($data);

        return redirect()->back()->with('message', 'Cancellation Rule updated.');
    }


    public function destroy(CancellationRule $cancellationRule)
    {
        $cancellationRule->delete();

        return redirect()->back()->with('message', 'Cancellation Rule deleted.');
    }
}
