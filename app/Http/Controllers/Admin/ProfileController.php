<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Sex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\EditRequest;
use App\Http\Resources\UserResource;
use App\Services\UploadFiles;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $user->load('media');
        return inertia('Admin/Profile/Edit', [
            'user' => UserResource::make($user),
            'sexes' => Sex::asSelect(),
        ]);
    }

    public function update(EditRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $user->update(except_keys($data, 'avatar'));
        UploadFiles::handle($user, $data['avatar'], 'avatar');

        return redirect()->back()->with('message', 'Profile updated successfully.');
    }
}
