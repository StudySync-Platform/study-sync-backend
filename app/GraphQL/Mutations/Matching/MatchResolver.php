<?php

namespace App\GraphQL\Mutations\Matching;

use App\Models\User;
use App\Services\MatchmakingClientService;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class MatchResolver
{
    public function __invoke($_, array $args, GraphQLContext $context)
    {
        $input = $args['input'];

        /** @var \App\Models\User $authUser */
        $authUser = $context->user();

        $matchService = app(MatchmakingClientService::class);

        try {
            $response = $matchService->requestMatch($authUser->id, $input);

            $matchedUser = null;
            if ($response->getMatched()) {
                $matchedUser = User::select('id', 'first_name', 'avatar_url', 'last_name')
                    ->find($response->getMatchedUserId());
            }

            Log::info('GraphQL Matchmaking Result', [
                'matched' => $response->getMatched(),
                'matched_user_id' => $response->getMatchedUserId(),
                'matched_user' => $matchedUser,
                'message' => $response->getMessage(),
            ]);

            return [
                'matched' => $response->getMatched(),
                'session_id' => $response->getSessionId(),
                'message' => $response->getMessage(),
                'matched_user' => $matchedUser,
            ];
        } catch (\Throwable $e) {
            Log::error('Matchmaking gRPC Error (GraphQL)', [
                'error' => $e->getMessage(),
            ]);
            throw new \Exception("Matchmaking failed. Please try again later.");
        }
    }
}
