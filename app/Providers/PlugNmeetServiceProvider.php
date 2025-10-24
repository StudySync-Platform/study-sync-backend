<?php

namespace App\Providers;

use App\Domain\Ports\PlugNmeet\MeetingGateway;
use App\Infrastructure\PlugNmeet\HttpMeetingGateway;
use Illuminate\Support\ServiceProvider;

class PlugNmeetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MeetingGateway::class, fn () => HttpMeetingGateway::fromConfig());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
