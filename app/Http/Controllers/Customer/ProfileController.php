<?php

namespace App\Http\Controllers\Customer;

use App\Enums\Sex;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\EditRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Country;
use App\Services\UploadFiles;

class ProfileController extends Controller
{
    public function edit()
    {
        $customer = auth('customer')->user();
        $customer->load(['media', 'national']);
        $countries = Country::all()->pluck('name', 'id');
        return inertia('Customer/Profile/Edit', [
            'customer' => CustomerResource::make($customer),
            'sexes' => Sex::asSelect(),
            'countries' => $countries,
        ]);
    }

    public function update(EditRequest $request)
    {
        $data = $request->validated();

        $customer = auth('customer')->user();

        $customer->update(except_keys($data, 'avatar'));
        UploadFiles::handle($customer, $data['avatar'], 'avatar');

        return redirect()->back()->with('message', 'Profile updated successfully.');
    }
}
