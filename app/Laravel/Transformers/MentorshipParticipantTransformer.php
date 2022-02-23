<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\User;
use App\Laravel\Models\Mentorship;
use App\Laravel\Models\MentorshipParticipant;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class MentorshipParticipantTransformer extends TransformerAbstract{

	protected $availableIncludes = [
		'info','author'
    ];


	public function transform(MentorshipParticipant $participant) {
	    return [
	     	'id' => $participant->id ?:0,
	     	'chat_id' => $participant->chat_id,
	     	'user_id' => $participant->user_id,
	     	'nickname' => $participant->nickname?:($participant->author?$participant->author->name:"Unknown User"),
	     	'role' => $participant->role,
	     ];
	}

	public function includeAuthor(MentorshipParticipant $participant){
       $user = $participant->author ? : new User;
       if(is_null($user->id)){ $user->id = 0;}
       return $this->item($user, new UserTransformer);
	}
	
	public function includeInfo(MentorshipParticipant $participant) {
		$collection = Collection::make([
			'date_created' => [
				'date_db' => $participant->date_db($participant->created_at,env("MASTER_DB_DRIVER","mysql")),
				'month_year' => $participant->month_year($participant->created_at),
				'time_passed' => $participant->time_passed($participant->created_at),
				'timestamp' => $participant->created_at
			],
		]);
		return $this->item($collection, new MasterTransformer);
	}

}