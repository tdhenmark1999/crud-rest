<?php

namespace App\Laravel\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Laravel\Models\WishlistComment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use App\Laravel\Transformers\TransformerManager;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Laravel\Transformers\WishlistCommentTransformer;

class NewCommentCreated implements ShouldBroadcast
{
    use SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WishlistComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('comment.'.$this->comment->wishlist_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $author = ['id' => 0, 'name' => "User", 'avatar' => "", 'fb_id' => ""];
        $tagged_user = ['id' => 0, 'name' => "User", 'avatar' => "", 'fb_id' => ""];

        if($this->comment->author) {
            $author['id'] = $this->comment->author->id;
            $author['name'] = strtolower($this->comment->author->username);
            $author['avatar'] = $this->comment->author->getAvatar();
            $author['fb_id'] = $this->comment->author->facebook 
                                ? $this->comment->author->facebook->provider_user_id
                                : NULL;
        }

        if($this->comment->tagged_user) {
            $tagged_user['id'] = $this->comment->tagged_user->id;
            $tagged_user['name'] = strtolower($this->comment->tagged_user->username);
            $tagged_user['avatar'] = $this->comment->tagged_user->getAvatar();
            $tagged_user['fb_id'] = $this->comment->tagged_user->facebook 
                                        ? $this->comment->tagged_user->facebook->provider_user_id
                                        : NULL;
        }

        return [
            'id' => $this->comment->id,
            'wishlist_id' => $this->comment->wishlist_id,
            'content' => $this->comment->content,
            'time_passed' => $this->comment->time_passed($this->comment->created_at),
            'author' => $author,
            'tagged_user' => $tagged_user,
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'NewCommentCreated';
    }
}