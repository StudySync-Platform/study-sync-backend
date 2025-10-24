<?php

namespace App\GraphQL\Mutations\Auth;

use Illuminate\Support\Facades\Auth;

final class Logout
{
    public function __invoke(): bool
    {
        $user = Auth::user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return true;
        }

        return false;
    }
}
