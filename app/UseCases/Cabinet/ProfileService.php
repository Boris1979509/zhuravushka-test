<?php

namespace App\UseCases\Cabinet;

use App\Http\Requests\Cabinet\ProfileUpdateRequest;
use App\Models\User;

class ProfileService
{
    public function edit($id, ProfileUpdateRequest $request): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $delivery_place = $request->only('city', 'street', 'house_number', 'apartment');
        $data = $request->except('phone', '_token', 'city', 'street', 'house_number', 'apartment') + compact('delivery_place');
        $user->update($data);
    }
}
