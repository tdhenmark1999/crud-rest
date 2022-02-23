<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\User;
use App\Laravel\Models\Mentorship;
use App\Laravel\Models\MentorshipParticipant;
use App\Laravel\Models\MentorshipConversation;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class MentorshipConversationTransformer extends TransformerAbstract{

	protected $availableIncludes = [
		'info','author','participant'
    ];

	public function transform(MentorshipConversation $message) {
		$content = $message->content;
		$type = $message->type;

		$user = Auth::user();

		if($user->id == $message->sender_user_id AND $message->sender_is_deleted == "yes"){
			$content = "You deleted a message";
			$type = "announcement";
		}

	    return [
	     	'id' => $message->id ?:0,
	     	'sender_user_id' => $message->sender_user_id,
	     	'content' => $content,
	     	'type' => $type,
	     ];
	}	

	public function includeInfo(MentorshipConversation $message) {
		$full_path = $thumb_path = "";

		if($message->type == "image"){
			$full_path = "{$message->directory}/resized/{$message->filename}";
			$thumb_path = "{$message->directory}/thumbnails/{$message->filename}";
		}

		if($message->type == "file"){
			$full_path = "{$message->directory}/{$message->filename}";
			$thumb_path = "{$message->directory}/{$message->filename}";
		}
		
		$collection = Collection::make([
			'date_created' => [
				'date_db' => $message->date_db($message->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $message->month_year($message->created_at),
				'time_passed' => $message->chat_time_passed($message->created_at),
				'timestamp' => $message->created_at
			],
			'attachment'  => [
	 			'filename' => $message->filename,
	 			'path' => $message->path,
	 			'directory' => $message->directory,
	 			'size' => $message->size,
	 			'full_path' => $full_path,
	 			'thumb_path' => $thumb_path,
			]
			
		]);
		return $this->item($collection, new MasterTransformer);
	}

	public function includeAuthor(MentorshipConversation $message){
       $user = $message->sender ? : new User;
       if(is_null($user->id)){ $user->id = 0;}
       return $this->item($user, new UserTransformer);
	}

	public function includeParticipant(MentorshipConversation $message){
       $particpant = $message->participant ? : new MentorshipParticipant;
       if(is_null($particpant->id)){ $particpant->id = 0;}
       return $this->item($particpant, new MentorshipParticipantTransformer);
	}

}