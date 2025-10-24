<?php

namespace App\GraphQL\Queries\Session;

use Illuminate\Support\Facades\Auth;

class UpcomingSessions
{
    public function __invoke($_, array $args)
    {
        $user = Auth::user();

        return $user->sessions()
            ->where('time', '>=', now())
            ->orderBy('time')
            ->take(3)
            ->get();
    }
}
