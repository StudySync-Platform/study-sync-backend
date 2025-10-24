<?php
namespace App\Application\UseCases\PlugNmeet;

use App\Application\DTOs\PlugNmeet\JoinDTO;
use App\Domain\Ports\PlugNmeet\MeetingGateway;

final class GetJoinToken
{
    public function __construct(private MeetingGateway $gateway) {}

    public function __invoke(JoinDTO $dto): string
    {
        $payload = [
            'room_id' => $dto->roomId,
            'user_info' => [
                'name' => $dto->name,
                'user_id' => $dto->userId,
                'is_admin' => $dto->isAdmin,
                'is_hidden' => $dto->isHidden,
                'user_metadata' => $dto->userMetadata,
            ],
        ];

        if ($dto->lockSettings) {
            $payload['lock_settings'] = $dto->lockSettings;
        }

        return $this->gateway->getJoinToken($payload);
    }
}
