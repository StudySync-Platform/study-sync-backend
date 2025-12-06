<?php

namespace App\GraphQL\Mutations\Habit;

use App\Models\Habit;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CreateHabit
{
    public function __invoke($_, array $args, GraphQLContext $context): Habit
    {
        $user = $context->user() ?? Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthenticated.');
        }

        $input = $args['input'];

        $habit = new Habit();
        $habit->user_id = $user->id;
        $habit->name = $input['name'];
        $habit->description = $input['description'] ?? null;
        $habit->target = $input['target'] ?? null;
        $habit->unit = $input['unit'] ?? null;
        $habit->visibility = $input['visibility'] ?? 'public';

        $habit->save();

        return $habit->fresh();
    }
}
