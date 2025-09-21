<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\CreateRequest;
use App\Http\Requests\Admin\Country\EditRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Services\QueryBuilder;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Country::class, 'country');
    }

    public function index()
    {
        $user = auth()->user();
        $countries = QueryBuilder::from(Country::class)
            ->mixedFilter('search', ['name', 'short'])
            ->sortFields([
                'name' => null,
                'short' => null,
            ])
            ->hasLimitRecord()
            ->latest()
            ->paginate()
            ->withQueryString()
            ->through(fn($country) => $country->setAttribute('can', [
                'edit' => $user->can('update', $country),
                'delete' => $user->can('delete', $country),
            ]));


        $resource = CountryResource::collection($countries);
        return inertia('Admin/Country/List', [
            'countries' => $resource,
            'filters' => request()->only('search'),
            'sorts' => request()->input('sorts'),
            'limit' => request()->integer('limit', config('app.per_page')),
            'can' => [
                'createUser' => $user->can('create', Country::class),
            ]
        ]);
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        Country::create($data);

        return redirect()->back()->with('message', 'Country created.');
    }

    public function update(EditRequest $request, Country $country)
    {
        $data = $request->validated();

        $country->update($data);

        return redirect()->back()->with('message', 'Country updated.');
    }


    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->back()->with('message', 'Country deleted.');
    }
}
