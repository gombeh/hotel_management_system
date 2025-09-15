<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\QueryBuilder;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
            ->withQueryString();



        $resource = UserResource::collection($users);
        return inertia('Admin/User/List', [
            'users' => $resource,
            'filters' => request()->only('search'),
            'sorts' => request()->input('sorts'),
            'limit' => request()->integer('limit', config('app.per_page')),
        ]);
    }

    public function store(CreateRequest $request)
    {
       $data = $request->validated();

       User::create($data);

        return redirect()->back()->with('message', 'User created.');
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
