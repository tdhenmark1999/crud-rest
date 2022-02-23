<?php 

namespace App\Laravel\Services;

use App\Laravel\Models\User;
use App\Laravel\Models\NewsletterSubscription;

use Illuminate\Validation\Validator;
use Auth, Hash,Str,Input;

class CustomValidator extends Validator {


    public function validateIsSubscribe($attribute,$value,$parameters){
        if(is_array($parameters) AND isset($parameters[0])){
            $type = Str::lower($parameters[0]);

            switch($type){
                case 'contact_number':
                    $ph_number = strpos($value, "+",0) !== FALSE ? str_replace("+63", "", $value) : substr($value, 1);

                    $is_subscribe = NewsletterSubscription::where('contact_number',"0{$ph_number}")
                                        ->orWhere('contact_number',"+63{$ph_number}")->first();
                    return $is_subscribe ? FALSE : TRUE;

                break;

                default:
                    $is_subscribe = NewsletterSubscription::where('email',Str::lower($value))->first();
                    return $is_subscribe ? FALSE : TRUE;
            }
        }

        return false;
    }
    public function validateValidCategory($attribute,$value,$parameters){
        return ArticleCategory::find($value);
    }

    public function validateValidAccount($attribute, $value, $parameters){
        $valid_accounts = ['mentor','mentee'];
        return in_array(Str::lower($value), $valid_accounts);
    }

    public function validateOldPassword($attribute, $value, $parameters){
        
        if($parameters){
            $user_id = $parameters[0];
            $user = User::find($user_id);
            return Hash::check($value,$user->password);
        }

        return FALSE;
    }

    public function validateValidCurrency($attribute,$value,$parameters){
        $code = Str::lower($value);
        $check = Currency::whereRaw("LOWER(code) = '{$code}'")->first();

        if($check){
            return TRUE;
        }

        return FALSE;
    }

    public function validateIsFollowing($attribute,$value,$parameters){
        $user_id = Input::user()->id;

        return Follower::where('user_id',(int)$value)->where('follower_id',$user_id)
                        ->count() ? TRUE : FALSE;
    }


    public function validatePasswordFormat($attribute,$value,$parameters){
    	return preg_match(("/^(?=.*)[A-Za-z\d][A-Za-z\d!@#$%^&*()_+.]{2,25}$/"), $value);
    }

    public function validateUsernameFormat($attribute,$value,$parameters){
    	return preg_match(("/^(?=.*)[A-Za-z\d][a-z\d._+]{2,20}$/"), $value);
    }

    public function validateUniqueUsername($attribute,$value,$parameters){
    	$username = Str::lower($value);
        $user_id = FALSE;
        if($parameters){
            $user_id = $parameters[0];
        }

        if($user_id){
            $is_unique = User::where('id','<>',$user_id)->whereRaw("LOWER(username) = '{$username}'")->whereIn('type',['mentor','mentee'])->first();
        }else{
            $is_unique = User::whereRaw("LOWER(username) = '{$username}'")->whereIn('type',['mentor','mentee'])->first();
        }

        return $is_unique ? FALSE : TRUE;
	}

    public function validateUniqueEmail($attribute,$value,$parameters){
    	$email = Str::lower($value);
        $user_id = FALSE;
        if($parameters){
            $user_id = $parameters[0];
        }

        if($user_id){
            $is_unique = User::where('id','<>',$user_id)->whereRaw("LOWER(email) = '{$email}'")->whereIn('type',['mentor','mentee'])->first();
        }else{
            $is_unique = User::whereRaw("LOWER(email) = '{$email}'")->whereIn('type',['mentor','mentee'])->first();
        }

        return $is_unique ? FALSE : TRUE;
	}

} 