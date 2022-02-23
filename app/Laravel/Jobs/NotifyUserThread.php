<?php

namespace App\Laravel\Jobs;

use App\Laravel\Models\User;
use Illuminate\Bus\Queueable;
use App\Laravel\Models\Follower;
use App\Laravel\Models\Wishlist;
use App\Laravel\Models\ActivityNotification;

use Illuminate\Queue\SerializesModels;
use App\Laravel\Models\WishlistComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Laravel\Notifications\Wishlist\WishlistCreatedNotification;
use App\Laravel\Notifications\WishlistComment\WishlistCommentCreatedOther;
use App\Laravel\Notifications\WishlistComment\GWishlistCommentCreatedOther;

use Carbon;

class NotifyUserThread implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comment;
    // protected $wishlist;

    /**
     * Create a new job instance.
     *
     * @param  WishlistComment  $comment
     * @return void
     */
    public function __construct(WishlistComment $comment)
    {
        $this->comment = $comment;
        // $this->wishlist = $wishlist;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $comment = WishlistComment::find($this->comment->id);
        $wishlist = Wishlist::where('id', $comment->wishlist_id)->first();
        
        $excluded_user = [
            $comment->tagged_user_id,
            $comment->user_id,
            $wishlist->user_id,
        ];

        // $distinct_users = WishlistComment::distinct('user_id')
        //                     ->where('wishlist_id', $comment->wishlist_id)
        //                     ->whereNotIn('user_id', $excluded_user)
        //                     ->pluck('user_id');

        // foreach ($distinct_users as $key => $d) {
        //     if($d->author){
        //         $d->author->notify(new WishlistCommentCreatedOther($comment));
        //     }
        // }

        // SELECT DISTINCT(user_id) FROM wishlist_comment

        // $distinct_users = WishlistComment::where('wishlist_id', $comment->wishlist_id)
        //                         ->whereNotIn('user_id', $excluded_user)
        //                         ->pluck('user_id')
        //                         ->toArray();

        $distinct_users = ActivityNotification::objectRefId($wishlist->id)
                                        ->objectType('COMMENT')
                                        ->objectIdentifier('comment_sawsaw')
                                        ->objectDate('today')
                                        ->orderBy('created_at','DESC')
                                        ->pluck('notifiable_id')
                                        ->toArray();



        if(count($distinct_users) > 0){
            $selected_users = implode(",", $distinct_users);
        }else{
            $selected_users  = "0";
        }
        $users = User::whereRaw("id IN ({$selected_users})")->get();

        foreach ($users as $key => $user) {

            $my_notif = ActivityNotification::where('notifiable_id',$user->id)
                                            ->objectRefId($wishlist->id)
                                            ->objectType('COMMENT')
                                            ->objectIdentifier('comment_sawsaw')
                                            ->objectDate('today')
                                            ->orderBy('created_at','DESC')
                                            ->first();
            if($my_notif){
                
                $notif_id = $my_notif->id;
                $my_notif = ActivityNotification::where('id',$notif_id)->update(['created_at' => Carbon::now(),'read_at' => null]);
                $user->notify( new GWishlistCommentCreatedOther($comment,$user->id,$notif_id) );
            }else{

                $name = $user->name;
                $avatar = $user->getAvatar();

                if($wishlist AND $wishlist->owner) {

                    $wishlist_owner = $wishlist->owner;

                    $owner = $wishlist_owner->name;

                    if($wishlist_owner->id == $author->id) {
                        $owner = $wishlist_owner->gender == "female" ? "her" : "his";
                    }
                }

                $data = [
                    'type' => "COMMENT",
                    'reference_id' => $comment->wishlist_id,
                    'title' => "{$name} also commented on a post.",
                    'content' => "{$name} also commented on {$owner} post. Click here to view.",
                    'thumbnail' => $avatar,
                ];

                $my_notif = ActivityNotification::create(['data' => "{$data}", 'notifiable_id' => $user->id, 'type' => "App\Laravel\Notifications\WishlistComment\WishlistCommentCreatedOther", 'notifiable_type' => "App\Laravel\Models\User"]);

                $user->notify( new GWishlistCommentCreatedOther($comment,$user->id,$my_notif->id) );

                // $user->notify( new WishlistCommentCreatedOther($comment,$user->id) );
            }

            // $user->notify(new GWishlistCommentCreatedOther($comment,$user->id));
        }
    }
}