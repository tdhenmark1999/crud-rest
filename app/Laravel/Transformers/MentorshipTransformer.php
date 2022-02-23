<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
// use App\Laravel\Models\Views\Chat;
use App\Laravel\Models\Mentorship;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class MentorshipTransformer extends TransformerAbstract{

	protected $availableIncludes = [
		'info','latest_message'
    ];


	public function transform(Mentorship $mentorship) {
		$user = Input::user();
	    return [
	     	'id' => $mentorship->id ?:0,
	     	'code' => $mentorship->code,
	     	'owner_user_id' => $mentorship->owner_user_id,
	     	'title' => $user->id == $mentorship->mentee_user_id ? $mentorship->mentor->name : $mentorship->mentee->name ,
	     	'mentee_user_id' => $mentorship->mentee_user_id,
	     	'mentor_user_id' => $mentorship->mentor_user_id,
	     	'status' => $mentorship->status,
	     	'transaction_status' => $mentorship->transaction_status,


	     ];
	}

	public function includeInfo(Mentorship $mentorship) {
		$user = Input::user();

		$other_user = $user->id == $mentorship->mentee_user_id ? $mentorship->mentor : $mentorship->mentee;
		

		if($other_user->filename){
			$full_path = "{$other_user->directory}/resized/{$other_user->filename}";
			$thumb_path = "{$other_user->directory}/thumbnails/{$other_user->filename}";
		}else{
			$full_path = $thumb_path = asset('placeholder/user.jpg');
		}

		$collection = Collection::make([
			'date_created' => [
				'date_db' => $mentorship->date_db($mentorship->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $mentorship->month_year($mentorship->created_at),
				'time_passed' => $mentorship->time_passed($mentorship->created_at),
				'timestamp' => $mentorship->created_at
			],
			'avatar' => [
				'path' => $other_user->directory,
	 			'filename' => $other_user->filename,
	 			'path' => $other_user->path,
	 			'directory' => $other_user->directory,
	 			'full_path' => $full_path,
	 			'thumb_path' => $thumb_path,
			],
		]);
		return $this->item($collection, new MasterTransformer);
	}

	public function includeLatestMessage(Mentorship $mentorship){
		$message = $mentorship->latest_message ? : new MentorshipConversation;
		if(is_null($message->id)){ $message->id = 0;}
		return $this->item($message, new MentorshipConversationTransformer);
	}

}