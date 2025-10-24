<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\MatchmakingClientService;

class MatchController extends Controller
{
    /**
     * Validate incoming request.
     */
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'subject' => 'required|string|max:255',
            'time_slot' => 'required|date_format:Y-m-d\TH:i',
            'level' => 'required|string|in:Beginner,Intermediate,Advanced',
            'study_mode' => 'nullable|string|in:Solo,Group',
            'group_size' => 'nullable|integer|min:1|max:10',
            'communication' => 'nullable|string|in:Audio,Video,Chat',
            'study_style' => 'nullable|string|max:255',
            'preferred_language' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:64',
            'desired_time' => 'nullable|string',
            'time_flex_minutes' => 'nullable|integer|min:0|max:120',
            'priority_weights' => 'nullable|array',
            'priority_weights.*' => 'integer|min:0|max:100',
        ]);
    }

    /**
     * Handle matchmaking request.
     */
    public function match(Request $request, MatchmakingClientService $matchService)
    {
        return $this->handleMatchRequest($request, $matchService);
    }

    /**
     * Retry matchmaking request (after rejecting a user).
     */
    public function retry(Request $request, MatchmakingClientService $matchService)
    {
        // Later you can log rejected user IDs here.
        return $this->handleMatchRequest($request, $matchService);
    }

    /**
     * Shared logic for match and retry.
     */
    private function handleMatchRequest(Request $request, MatchmakingClientService $matchService)
    {
        $validated = $this->validateRequest($request);

        try {
            $response = $matchService->requestMatch(auth()->id(), $validated);

            $matchedUser = null;
            if ($response->getMatched()) {
                $matchedUser = User::select('id', 'first_name', 'avatar_url', 'last_name')
                    ->find($response->getMatchedUserId());
            }

            $payload = [
                'matched' => $response->getMatched(),
                'session_id' => $response->getSessionId(),
                'matched_user_id' => $response->getMatchedUserId(),
                'matched_user' => $matchedUser,
                'message' => $response->getMessage(),
            ];

            Log::info('Matchmaking response', $payload);

            return response()->json($payload);
        } catch (\Throwable $e) {
            Log::error('Matchmaking error', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Matchmaking failed. Please try again later.',
            ], 500);
        }
    }
}
