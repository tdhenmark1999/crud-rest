<?php

namespace App\Laravel\Notifications\Messages;

use Illuminate\Bus\Queueable;

class BroadcastMessage
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The data for the notification.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set the message data.
     *
     * @param  array  $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }
}
