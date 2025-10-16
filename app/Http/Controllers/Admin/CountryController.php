<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\CreateRequest;
use App\Http\Requests\Admin\Country\EditRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Services\Filters\FilterSearch;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Country::class, 'country');
    }

    public function index(Request $request)
    {
        $limit = $request->limit;
        $user = auth()->user();
        $countries = QueryBuilder::for(Country::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FilterSearch(['name', 'short']))
            ])->allowedSorts([
                'name',
                'short'
            ])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($country) => $country->setAttribute('access', [
                'edit' => $user->can('update', $country),
                'delete' => $user->can('delete', $country),
            ]));

        return inertia('Admin/Country/List', [
            'countries' => CountryResource::collection($countries),
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
            'access' => [
                'createCountry' => $user->can('create', Country::class),
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
