<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\EditRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Filters\FilterSearch;
use App\Services\Sorts\MultiColumnSort;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $limit = $request->limit;
        $roles = Role::all()->pluck('name', 'id');
        $users = QueryBuilder::for(User::class)
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
            ->through(fn($user) => $user->setAttribute('can', [
                'edit' => auth()->user()->can('update', $user),
                'delete' => auth()->user()->can('delete', $user) && $user->id !== 1,
            ]));

        $resource = UserResource::collection($users);
        return inertia('Admin/User/List', [
            'roles' => $roles,
            'users' => $resource,
            'filters' => request()->input('filters') ?? (object)[],
            'sorts' => request()->input('sorts') ?? "",
            'limit' => $limit,
            'can' => [
                'createUser' => auth()->user()->can('create', User::class),
            ]
        ]);
    }


    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
        $user->roles()->sync($data['roles']);

        return redirect()->back()->with('message', 'User created.');
    }


    public function update(EditRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) unset($data['password']);

        $user->update($data);
        $user->roles()->sync($data['roles']);

        return redirect()->back()->with('message', 'User updated.');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('message', 'User deleted.');
    }
}
