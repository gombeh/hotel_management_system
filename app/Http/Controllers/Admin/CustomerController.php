<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Sex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\CreateRequest;
use App\Http\Requests\Admin\Customer\EditRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\Filters\FilterSearch;
use App\Services\Sorts\MultiColumnSort;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
    }

    public function index(Request $request)
    {
        $limit = $request->limit;
        $user = auth()->user();
        $customers = QueryBuilder::for(Customer::class)
            ->with('roles')
            ->allowedFilters([
                AllowedFilter::custom('search', new FilterSearch(['first_name', 'last_name', 'email']))
            ])->allowedSorts([
                'email',
                AllowedSort::custom('full-name', new MultiColumnSort(['first_name', 'last_name'])),
            ])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($customer) => $customer->setAttribute('can', [
                'edit' => $user->can('update', $customer),
                'delete' => $user->can('delete', $customer),
            ]));

        return inertia('Admin/Customer/List', [
            'users' => CustomerResource::collection($customers),
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'sexes' => Sex::asSelect(),
            'limit' => $limit,
            'can' => [
                'createUser' => $user->can('create', Customer::class),
            ]
        ]);
    }

    public function show(Customer $customer)
    {
        $customer->load('national');
        return CustomerResource::make($customer);
    }


    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        Customer::create($data);

        return redirect()->back()->with('message', 'Customer created.');
    }


    public function update(EditRequest $request, Customer $customer)
    {
        $data = $request->validated();

        if (empty($data['password'])) unset($data['password']);

        $customer->update($data);

        return redirect()->back()->with('message', 'Customer updated.');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with('message', 'Customer deleted.');
    }
}
