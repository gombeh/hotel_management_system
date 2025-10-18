<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerStatus;
use App\Enums\Sex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\CreateRequest;
use App\Http\Requests\Admin\Customer\EditRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\Filters\FilterSearch;
use App\Services\Sorts\MultiColumnSort;
use DB;
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
            ->complete()
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::custom('search', new FilterSearch(['first_name', 'last_name', 'email']))
            ])->allowedSorts([
                'email',
                'status',
                AllowedSort::custom('full-name', new MultiColumnSort(['first_name', 'last_name'])),
            ])
            ->latest()
            ->paginate($limit)
            ->withQueryString()
            ->through(fn($customer) => $customer->setAttribute('access', [
                'edit' => $user->can('update', $customer),
                'delete' => $user->can('delete', $customer),
                'show' => $user->can('view', $customer),
            ]));

        return inertia('Admin/Customer/List', [
            'customers' => CustomerResource::collection($customers),
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'sexes' => Sex::asSelect(),
            'statuses' => CustomerStatus::asSelect(),
            'limit' => $limit,
            'access' => [
                'createCustomer' => $user->can('create', Customer::class),
            ]
        ]);
    }

    public function show(Customer $customer)
    {
        $customer->load('national');

        return inertia('Admin/Customer/Show', [
            'customer' => new CustomerResource($customer),
            'statuses' => CustomerStatus::asSelect(),
        ]);
    }


    public function store(CreateRequest $request)
    {
        $data = $request->validated();


        $data = [
            ...$data,
            'email_verified_at' => now(),
            'is_complete' => true,
            'mobile_verified_at' => !empty($data['mobile']) ? now() : null,
        ];

        Customer::create($data);

        return redirect()->back()->with('message', 'Customer created.');
    }


    public function update(EditRequest $request, Customer $customer)
    {
        $data = $request->validated();

        if (empty($data['password'])) unset($data['password']);
        $data['mobile_verified_at'] = !empty($data['mobile']) ? now() : null;

        $customer->update($data);

        if($customer->isInActive()){
            $sessions = DB::table('sessions')
                ->where('user_id', $customer->id)
                ->get();

            foreach ($sessions as $session) {
                \Session::getHandler()->destroy($session->id);
            }
        }

        return redirect()->back()->with('message', 'Customer updated.');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->back()->with('message', 'Customer deleted.');
    }
}
