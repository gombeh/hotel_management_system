<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\EditRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = QueryBuilder::from(User::class)
            ->mixedFilter('search', ['first_name', 'last_name', 'email'])
            ->sortFields([
                'full_name' => ['first_name', 'last_name'],
                'email' => null,
            ])
            ->hasLimitRecord()
            ->latest()
            ->paginate()
            ->withQueryString()
            ->through(fn($user) => $user->setAttribute('can', [
                'edit' => auth()->user()->can('update', $user),
                'delete' => auth()->user()->can('delete', $user),
            ]));


        $resource = UserResource::collection($users);
        return inertia('Admin/User/List', [
            'users' => $resource,
            'filters' => request()->only('search'),
            'sorts' => request()->input('sorts'),
            'limit' => request()->integer('limit', config('app.per_page')),
            'can' => [
                'createUser' => auth()->user()->can('create', User::class),
            ]
        ]);
    }


    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        User::create($data);

        return redirect()->back()->with('message', 'User created.');
    }


    public function update(EditRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) unset($data['password']);

        $user->update($data);

        return redirect()->back()->with('message', 'User updated.');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('message', 'User deleted.');
    }
}
