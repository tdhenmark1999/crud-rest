<?php 

namespace App\Laravel\Transformers;

use App\Laravel\Models\User;
use App\Laravel\Models\Mentorship;
use App\Laravel\Models\Chat;
use App\Laravel\Models\Article;


use League\Fractal\TransformerAbstract;
use Helper,Str;

class NotificationTransformer extends TransformerAbstract{

	protected $availableIncludes = [
        'user'
    ];

	public function transform($notification){

		$deleted_display = "REMOVED";
		$is_deleted = false;
		switch(Str::lower($notification->data['type'])){
			case 'user':
				$deleted_display = "DEACTIVATED";
				$transaction = User::find($notification->data['reference_id']);

				$is_deleted = !$transaction  ? true : false;
			break;

			case 'chat':
				$transaction = Chat::find($notification->data['reference_id']);

				$is_deleted = !$transaction  ? true : false;
			break;

			case 'mentorship':
				$transaction = Mentorship::find($notification->data['reference_id']);

				$is_deleted = !$transaction  ? true : false;
			break;

			case 'article':
				$transaction = Article::find($notification->data['reference_id']);

				$is_deleted = !$transaction  ? true : false;
			break;
			
		}

		$payload =  [
			'id' => $notification->id ?:0,
			'event'=> $notification->type,
			'is_read' => $notification->read_at != NULL ? "yes" : "no",
			'time_passed' => Helper::time_passed($notification->created_at),
			'reference_id' => isset($notification->data['reference_id']) ? $notification->data['reference_id'] : '',
			'type' => isset($notification->data['type']) ? $notification->data['type'] : '',
			'title' => isset($notification->data['title']) ? $notification->data['title'] : '',
			'content' => isset($notification->data['content']) ? $notification->data['content'] : '',
			'thumbnail' => isset($notification->data['thumbnail']) ? $notification->data['thumbnail'] : '',
			'is_deleted' => $is_deleted,
			'deleted_display' => "REMOVED"
		];

		return $payload;
	}

	public function includeUser($notification) {
		return $this->item(User::findOrNew($notification->notifiable_id), new UserTransformer);
	}

}