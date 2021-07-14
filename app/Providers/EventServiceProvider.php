<?php

namespace App\Providers;

use App\Events\Game\LobbyJoinedEvent;
use App\Models\Game;
use App\Observers\GameObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

//        LobbyJoinedEvent::class => [ /* nth */]
    ];

    public function boot(): void
    {
        Game::observe(GameObserver::class);
    }
}
