<?php

namespace App\GraphQL\Mutations\Habit;

use App\Models\Habit;
use App\Models\HabitProgress;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UpdateHabitProgress
{
    public function __invoke($_, array $args, GraphQLContext $context): HabitProgress
    {
        $user = $context->user() ?? Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'Unauthenticated.');
        }

        $input = $args['input'];

        $habit = Habit::findOrFail($input['habit_id']);

        // Ensure the user is the owner (or you can relax per your rules)
        if ($habit->user_id !== $user->id) {
            // allow other users to add progress for themselves (same habit_id could be shared?)
            // For now require owner
            throw new UnauthorizedHttpException('Bearer', 'Forbidden.');
        }

        $progress = HabitProgress::firstOrNew([
            'habit_id' => $input['habit_id'],
            'user_id' => $user->id,
            'progress_date' => $input['progress_date'],
        ]);

        $progress->value = $input['value'];
        $progress->note = $input['note'] ?? null;

        $progress->save();

        return $progress->fresh();
    }
}
