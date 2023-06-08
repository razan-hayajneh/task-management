<?php

namespace App\Actions\Fortify;

use App\Traits\UploadTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    use UploadTrait;

    /**
     * Validate and update the given user's profile information.
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'size:10', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (!empty($user['image_url'])) {
            $this->deleteFile($user['image_url'], 'profile');
        }
        if (isset($input['photo'])) {
            $input['image_url'] = $this->uploadFile($input['photo'], 'profile');
            $user->forceFill([
                'image_url' => $input['image_url'],
            ])->save();
        }
        $user->forceFill([
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
        ])->save();
    }
}
