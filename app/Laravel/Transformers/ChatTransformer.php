<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\Chat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class ChatTransformer extends TransformerAbstract{

	protected $availableIncludes = [
		'info','latest_message'
    ];


	public function transform(Chat $chat) {
	    return [
	     	'id' => $chat->id ?:0,
	     	'owner_user_id' => $chat->owner_user_id,
	     	'title' => $chat->title,
	     ];
	}

	public function includeInfo(Chat $chat) {

		if($chat->filename){
			$full_path = "{$chat->directory}/resized/{$chat->filename}";
			$thumb_path = "{$chat->directory}/thumbnails/{$chat->filename}";
		}else{
			$full_path = $thumb_path = asset('placeholder/group.jpg');
		}

		$collection = Collection::make([
			'date_created' => [
				'date_db' => $chat->date_db($chat->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $chat->month_year($chat->created_at),
				'time_passed' => $chat->time_passed($chat->created_at),
				'timestamp' => $chat->created_at
			],
			'avatar' => [
				'path' => $chat->directory,
	 			'filename' => $chat->filename,
	 			'path' => $chat->path,
	 			'directory' => $chat->directory,
	 			'full_path' => $full_path,
	 			'thumb_path' => $thumb_path,
			],
		]);
		return $this->item($collection, new MasterTransformer);
	}

	public function includeLatestMessage(Chat $chat){
		$message = $chat->latest_message ? : new ChatConversation;
		if(is_null($message->id)){ $message->id = 0;}
		return $this->item($message, new ChatConversationTransformer);
	}

}