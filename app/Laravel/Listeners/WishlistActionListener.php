<?php

namespace App\Laravel\Listeners;

use Carbon, Helper;
use App\Laravel\Models\User;
use App\Laravel\Models\Wishlist;
use App\Laravel\Models\Follower;
use App\Laravel\Models\WishlistLog;
use App\Laravel\Events\WishlistAction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Laravel\Notifications\Wishlist\WishlistCreatedNotification;

class WishlistActionListener implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserAction  $event
     * @return void
     */
    public function handle(WishlistAction $event)
    {
        $user = $event->user;
        $wishlist = $event->wishlist;
        $action = $event->action;

        $owner_name = $wishlist->owner ? $wishlist->owner->name : '';

        switch (strtolower($action)) {
            case 'wishlist_created':
                $log = new WishlistLog;
                $log->fill(['user_id' => 0, 'wishlist_id' => $wishlist->id, 'content' => "Post created."]);
                $log->save();
            break;

            case 'permission_request_sent':
                $log = new WishlistLog;
                $log->fill(['user_id' => $user->id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("SELF_PERMISSION_REQUEST_SENT_NOTIFICATION_CONTENT", ['name' => $owner_name]);
                $log->save();

                $log = new WishlistLog;
                $log->fill(['user_id' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("PERMISSION_REQUEST_SENT_NOTIFICATION_CONTENT", ['name' => $user->name, 'wishlist' => $wishlist->title]);
                $log->save();
            break;

            case 'permission_granted':
                $log = new WishlistLog;
                $log->fill(['user_id' => $user->id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("PERMISSION_GRANTED_NOTIFICATION_CONTENT", ['name' => $owner_name]);
                $log->save();

                $log = new WishlistLog;
                $log->fill(['user_id' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("SELF_PERMISSION_GRANTED_NOTIFICATION_CONTENT", ['name' => $user->name, 'wishlist' => $wishlist->title]);
                $log->save();
            break;

            case 'gift_sent':
                $log = new WishlistLog;
                $log->fill(['user_id' => $user->id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("SELF_GIFT_SENT_NOTIFICATION_CONTENT", ['name' => $owner_name, 'wishlist' => $wishlist->title]);
                $log->save();

                $log = new WishlistLog;
                $log->fill(['user_id' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("GIFT_SENT_NOTIFICATION_CONTENT", ['wishlist' => $wishlist->title]);
                $log->save();
            break;

            case 'gift_received':
                $log = new WishlistLog;
                $log->fill(['user_id' => $user->id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("GIFT_RECEIVED_NOTIFICATION_CONTENT", ['name' => $owner_name, 'wishlist' => $wishlist->title]);
                $log->save();

                $log = new WishlistLog;
                $log->fill(['user_id' => $wishlist->user_id, 'wishlist_id' => $wishlist->id]);
                $log->content = Helper::get_response_message("SELF_GIFT_RECEIVED_NOTIFICATION_CONTENT", ['name' => $user->name, 'wishlist' => $wishlist->title]);
                $log->save();
            break;
        }
    }
}
