<?php
namespace App\Application\DTOs\PlugNmeet;

final class CreateRoomDTO
{
    public function __construct(
        public string $roomId,
        public string $title,
        public ?string $welcomeMessage = null,
        public ?string $webhookUrl = null,
        public ?string $logoutUrl = null,
        public array $roomFeatures = [],
        public array $defaultLockSettings = [],
        public ?int $maxParticipants = null,
        public ?int $emptyTimeoutSec = null,
    ) {}
}
