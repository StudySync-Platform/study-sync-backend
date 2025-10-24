<?php

namespace App\GraphQL\Mutations\Matching;

use App\Models\User;
use App\Services\MatchmakingClientService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RetryMatchResolver
{
    public function __invoke(null $_, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $input = $args['input'];

        // ✅ Parse date/time fields
        if (isset($input['time_slot'])) {
            $input['time_slot'] = Carbon::parse($input['time_slot'])->toIso8601String();
        }

        if (isset($input['desired_time'])) {
            $input['desired_time'] = Carbon::parse($input['desired_time'])->toIso8601String();
        }

        // ✅ Get authenticated user
        $user = $context->user();
        if (!$user) {
            throw new \Exception('❌ Unauthorized: You must be logged in.');
        }

        try {
            $matchService = new MatchmakingClientService();
            $userId = $user->id;

            // ✅ Send request to matchmaking microservice
            $response = $matchService->requestMatch($userId, $input);

            $matchedUser = null;
            if ($response->getMatched()) {
                $matchedUser = User::select('id', 'first_name', 'last_name', 'avatar_url')
                    ->find($response->getMatchedUserId());
            }

            $payload = [
                'matched' => $response->getMatched(),
                'session_id' => $response->getSessionId(),
                'message' => $response->getMessage(),
                'matched_user' => $matchedUser,
            ];

            Log::info('✅ GraphQL Matchmaking Success', $payload);

            return $payload;
        } catch (\Throwable $e) {
            Log::error('❌ GraphQL Matchmaking Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $input,
                'user_id' => $user->id ?? null,
            ]);

            throw new \Exception('❌ Matchmaking failed. Please try again later.');
        }
    }
}
