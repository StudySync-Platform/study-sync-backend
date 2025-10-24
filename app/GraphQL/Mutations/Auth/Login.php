<?php

namespace App\GraphQL\Mutations\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login
{
    public function __invoke($_, array $args)
    {
        $credentials = $args['input'];

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
