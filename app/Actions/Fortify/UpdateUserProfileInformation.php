<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'phone' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],

            'password' => ['nullable', 'min:6', 'confirmed']
        ])->validateWithBag('updateProfileInformation');

        $user->forceFill([
            'name' => $input['name'],
            'phone' => $this->formatPhone($input['phone'])
        ])->save();

        $this->updatePassword($user, $input['password']);
    }

    /**
     * @param $user
     * @param $password
     * @return void
     */
    protected function updatePassword($user, $password)
    {
        $user->forceFill([
            'password' => Hash::make($password),
        ])->save();
    }

    protected function formatPhone($phone)
    {
        // TODO: Каую-нить функцию для приведения к единому формату номера
        return $phone;
    }
}
