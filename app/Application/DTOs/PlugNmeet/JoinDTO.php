<?php
namespace App\Application\DTOs\PlugNmeet;

final class JoinDTO
{
    public function __construct(
        public string $roomId,
        public string $name,
        public string $userId,
        public bool $isAdmin = false,
        public bool $isHidden = false,
        public array $userMetadata = [],   // e.g. ['preferred_lang'=>'es-ES']
        public ?array $lockSettings = null
    ) {}
}
