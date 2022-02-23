<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Laravel\Events\UserAction' => [
            'App\Laravel\Listeners\UserActivityListener',
            'App\Laravel\Listeners\UserLoginListener',
            'App\Laravel\Listeners\UserRegisterListener',
            'App\Laravel\Listeners\UpdateUserDevice',

        ],
        'App\Laravel\Events\WishlistAction' => [
            'App\Laravel\Listeners\WishlistActionListener',
        ],
        'Illuminate\Notifications\Events\NotificationSent' => [
            'App\Laravel\Listeners\ReadSelfNotification',
        ],
        'log-activity' => [
            'App\Laravel\Listeners\AuditTrailActivityListener'
        ],

        'App\Laravel\Events\SendEmail' => [
            'App\Laravel\Listeners\SendEmailListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
