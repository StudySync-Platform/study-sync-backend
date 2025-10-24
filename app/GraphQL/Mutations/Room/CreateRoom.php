<?php

namespace App\GraphQL\Mutations\Room;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreateRoom
{
    public function __invoke($_, array $args)
    {
        $input = $args['input'];

        // Require authenticated user
        $user = Auth::user();
        if (!$user) {
            throw ValidationException::withMessages([
                'auth' => ['You must be logged in to create a room.']
            ]);
        }

        // Inject host_user_id from authenticated user
        $input['host_user_id'] = $user->id;

        // Create the room
        $room = Room::create($input);

        return $room;
    }
}
