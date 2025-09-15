<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\QueryBuilder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = QueryBuilder::from(User::class)
            ->mixedFilter('search', ['first_name', 'last_name', 'email'])
            ->sortFields([
                'full_name' => ['first_name', 'last_name'],
                'email' => null,
            ])
            ->hasLimitRecord()
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
