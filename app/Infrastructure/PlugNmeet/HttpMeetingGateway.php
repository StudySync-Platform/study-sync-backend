<?php

namespace App\Infrastructure\PlugNmeet;

use App\Domain\Ports\PlugNmeet\MeetingGateway;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class HttpMeetingGateway implements MeetingGateway
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey,
        private readonly string $apiSecret,
        private readonly string $createRoomPath,
        private readonly string $joinTokenPath,
        private readonly string $endRoomPath,
        private readonly int $timeoutSeconds = 5,
    ) {}

    private function client(): PendingRequest
    {
        // minimal HMAC header — adjust to your server’s real auth
        $ts  = (string) now()->timestamp;
        $sig = hash_hmac('sha256', $this->apiKey.$ts, $this->apiSecret);

        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->asJson()
            ->timeout($this->timeoutSeconds)
            ->retry(1, 200) // one quick retry
            ->withHeaders([
                'X-API-KEY' => $this->apiKey,
                'X-API-TS'  => $ts,
                'X-API-SIG' => $sig,
            ]);
    }

    /** @inheritDoc */
    public function createRoom(array $payload): array
    {
        $res = $this->client()->post($this->createRoomPath, $payload);

        if (!$res->successful()) {
            throw new RuntimeException('PlugNmeet createRoom failed: '.$res->body());
        }

        return $res->json() ?? [];
    }

    /** @inheritDoc */
    public function getJoinToken(array $payload): string
    {
        $res = $this->client()->post($this->joinTokenPath, $payload);

        if (!$res->successful()) {
            throw new RuntimeException('PlugNmeet getJoinToken failed: '.$res->body());
        }

        $token = $res->json('data.token') ?? $res->json('token');
        if (!$token) {
            throw new RuntimeException('PlugNmeet getJoinToken: token missing in response.');
        }

        return (string) $token;
    }

    /** @inheritDoc */
    public function endRoom(string $roomId): bool
    {
        $res = $this->client()->post($this->endRoomPath, ['room_id' => $roomId]);

        if ($res->status() === 404) {
            // treat "already ended/not found" as idempotent success
            return true;
        }

        if (!$res->successful()) {
            throw new RuntimeException('PlugNmeet endRoom failed: '.$res->body());
        }

        return (bool) ($res->json('success') ?? true);
    }

    public static function fromConfig(): self
    {
        $cfg = config('plugnmeet');

        return new self(
            baseUrl:        $cfg['base_url'],
            apiKey:         $cfg['api_key'],
            apiSecret:      $cfg['api_secret'],
            createRoomPath: $cfg['endpoints']['create_room'],
            joinTokenPath:  $cfg['endpoints']['join_token'],
            endRoomPath:    $cfg['endpoints']['end_room'],
            timeoutSeconds: (int) $cfg['timeout_seconds'],
        );
    }
}
