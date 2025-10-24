<?php
namespace App\Domain\Ports\PlugNmeet;

interface MeetingGateway
{
    /** @return array raw API response */
    public function createRoom(array $payload): array;

    /** @return string join token */
    public function getJoinToken(array $payload): string;

    public function endRoom(string $roomId): bool;
}
