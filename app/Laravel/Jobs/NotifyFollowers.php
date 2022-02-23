<?php

namespace App\Laravel\Jobs;

use App\Laravel\Models\User;
use Illuminate\Bus\Queueable;
use App\Laravel\Models\Follower;
use App\Laravel\Models\Wishlist;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Laravel\Notifications\Wishlist\WishlistCreatedNotification;

class NotifyFollowers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $wishlist;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @param  Wishlist  $wishlist
     * @return void
     */
    public function __construct(User $user, Wishlist $wishlist)
    {
        $this->user = $user;
        $this->wishlist = $wishlist;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wishlist = Wishlist::find($this->wishlist->id);
        $followers = Follower::where('user_id', $this->user->id)->get();

        foreach ($followers as $key => $f) {
            if($f->follower){
                $f->follower->notify(new WishlistCreatedNotification($wishlist));
            }
        }
    }
}