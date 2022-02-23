<?php

namespace App\Laravel\Notifications\Self\Social;

use App\Laravel\Models\User;
use App\Laravel\Notifications\SelfNotification;
use Helper;

class WelcomeNotification extends SelfNotification
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $data = [
            'type' => "USER",
            'reference_id' => $user->id,
            'title' => Helper::get_response_message("WELCOME_MESSAGE", ['name' => $user->name]),
            'content' => Helper::get_response_message("WELCOME_MESSAGE", ['name' => $user->name]),
            'thumbnail' => $user->getAvatar(),
        ];

        $this->setData($data);
    }
}
