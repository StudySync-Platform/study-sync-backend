<?php
namespace App\Domain\Ports\PlugNmeet;

use App\Application\DTOs\PlugNmeet\CreateRoomDTO;

final class CreateRoom
{
    public function __construct(private MeetingGateway $gateway) {}

    public function __invoke(CreateRoomDTO $dto): array
    {
        $payload = [
            'room_id' => $dto->roomId,
            'max_participants' => $dto->maxParticipants,
            'empty_timeout' => $dto->emptyTimeoutSec,
            'metadata' => array_filter([
                'room_title' => $dto->title,
                'welcome_message' => $dto->welcomeMessage,
                'webhook_url' => $dto->webhookUrl,
                'logout_url' => $dto->logoutUrl,
                'room_features' => $dto->roomFeatures,
                'default_lock_settings' => $dto->defaultLockSettings,
            ], fn($v) => $v !== null),
        ];

        return $this->gateway->createRoom($payload);
    }
}
