<?php

namespace App\GraphQL\Mutations\Session;

use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class CreateSession
{
    public function __invoke($_, array $args)
    {
        $user = Auth::user();

        return $user->sessions()->create([
            'emoji' => $args['input']['emoji'],
            'subject' => $args['input']['subject'],
            'time' => $args['input']['time'],
            'status' => $args['input']['status'],
        ]);
    }
}
