<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MealPlan\CreateRequest;
use App\Http\Requests\Admin\MealPlan\EditRequest;
use App\Http\Resources\MealPlanResource;
use App\Models\MealPlan;

class MealPlanController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MealPlan::class, 'mealPlan');
    }

    public function index()
    {
        $user = auth()->user();
        $mealPlans = MealPlan::latest()->get()->map(fn($mealPlan) => $mealPlan->setAttribute('access', [
            'edit' => $user->can('update', $mealPlan),
            'delete' => $user->can('delete', $mealPlan),
        ]));

        return inertia("Admin/MealPlan/List", [
            'mealPlans' => MealPlanResource::collection($mealPlans),
            'access' => [
                'createMealPlan' => $user->can('create', MealPlan::class),
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        MealPlan::create($data);

        return redirect()->back()->with('message', 'Meal plan created.');
    }

    public function update(EditRequest $request, MealPlan $mealPlan)
    {
        $data = $request->validated();

        $mealPlan->update($data);

        return redirect()->back()->with('message', 'Meal plan updated.');
    }


    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();

        return redirect()->back()->with('message', 'Meal plan deleted.');
    }
}
