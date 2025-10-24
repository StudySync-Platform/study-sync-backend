<?php

namespace App\GraphQL\Queries\Auth;

use Illuminate\Support\Facades\Auth;

class Me
{
    public function __invoke($_, array $args)
    {
        return Auth::user(); // Protect here
    }
}
