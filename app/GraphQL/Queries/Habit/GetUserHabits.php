<?php

namespace App\GraphQL\Queries\Habit;

use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GetUserHabits
{
    public function __invoke($_, array $args, GraphQLContext $context)
    {
        $user = $context->user() ?? Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthenticated.');
        }

        return Habit::where('user_id', $user->id)
            ->with('progresses')
            ->orderByDesc('created_at')
            ->get();
    }
}
