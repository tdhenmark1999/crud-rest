<?php

namespace App\Laravel\Jobs;

use App\Laravel\Models\User;
use Illuminate\Bus\Queueable;
use App\Laravel\Models\Follower;
use App\Laravel\Models\Wishlist;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Laravel\Models\UserIOS as IOSUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Laravel\Notifications\FCMNotification;
use App\Laravel\Models\UserAndroid as AndroidUser;

class NotifyUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $device_name;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  string  $device_name
     * @param  array  $data
     * @return void
     */
    public function __construct($device_name, array $data)
    {
        $this->device_name = $device_name;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->device_name) {
            case 'android':
                $users = AndroidUser::where('type', "user")->get();
            break;
            case 'ios':
                $users = IOSUser::where('type', "user")->get();
            break;
            default:
                $users = array();
            break;
        }

        foreach ($users as  $user) {
            $user->notify(new FCMNotification($this->data));
        }
    }
}