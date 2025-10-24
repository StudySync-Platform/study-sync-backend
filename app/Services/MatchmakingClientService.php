<?php

namespace App\Services;

use Matchmaking\MatchRequest;
use Matchmaking\MatchmakingServiceClient;
use Grpc\ChannelCredentials;
use Exception;

class MatchmakingClientService
{
    protected MatchmakingServiceClient $client;

    public function __construct()
    {
        $this->client = new MatchmakingServiceClient(
            '127.0.0.1:50051',
            ['credentials' => ChannelCredentials::createInsecure()]
        );
    }

    /**
     * Sends a MatchRequest to the Go matchmaking engine.
     */
    public function requestMatch(int $userId, array $data)
    {
        $request = new MatchRequest();
        $request->setUserId($userId);
        $request->setSubject($data['subject']);
        $request->setTimeSlot($data['time_slot']);
        $request->setLevel($data['level']);

        // Optional fields
        if (!empty($data['study_mode'])) {
            $request->setStudyMode($data['study_mode']);
        }

        if (!empty($data['group_size'])) {
            $request->setGroupSize($data['group_size']);
        }

        if (!empty($data['communication'])) {
            $request->setCommunication($data['communication']);
        }

        if (!empty($data['study_style'])) {
            $request->setStudyStyle($data['study_style']);
        }

        if (!empty($data['preferred_language'])) {
            $request->setPreferredLanguage($data['preferred_language']);
        }

        if (!empty($data['timezone'])) {
            $request->setTimezone($data['timezone']);
        }

        if (!empty($data['desired_time'])) {
            $request->setDesiredTime($data['desired_time']);
        }

        if (!empty($data['time_flex_minutes'])) {
            $request->setTimeFlexMinutes($data['time_flex_minutes']);
        }

        // Handle priority_weights map<string, int32>
        if (!empty($data['priority_weights'])) {
            $request->setPriorityWeights($data['priority_weights']);
        }

        [$response, $status] = $this->client->RequestMatch($request)->wait();

        if ($status->code !== \Grpc\STATUS_OK) {
            throw new Exception("gRPC Error: {$status->details}");
        }

        return $response;
    }
}
