<?php
namespace App\Domain\Entities\PlugNmeet;

final class Room
{
    public function __construct(
        public string $id,
        public string $title,
        public ?string $webhookUrl = null,
        public ?string $logoutUrl = null,
    ) {}
}
