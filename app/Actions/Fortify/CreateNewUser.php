<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\UserRegister;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use LogsActivity;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'phone' => ['required', 'string', 'max:20'],
            'referral_code' => ['string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $payload = [
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone' => $input['phone'],
            'referral_code' => $input['referral_code'] ?? null,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ];
        $user = User::create($payload);
        $user->assignRole('lid');
        $user->notify(new UserRegister());
        $user->balance = 20;
        $user->save();

        $this->logActivity('User registered', $payload, $user->id);

        return $user;
    }
}
