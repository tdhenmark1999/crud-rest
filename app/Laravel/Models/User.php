<?php

namespace App\Laravel\Models;

use Carbon, Helper;
use App\Laravel\Models\Views\UserGroup;
use Illuminate\Notifications\Notifiable;
use App\Laravel\Traits\DateFormatterTrait;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable, SoftDeletes, DateFormatterTrait;

    protected $table = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'contact_number',
        'password',
        /*'description', */'path', 'directory', 'filename', 
        'last_notification_check','currency','fb_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $appends = ['avatar'];

    public function getAvatarAttribute(){

        if($this->filename){
            return "{$this->directory}/resized/{$this->filename}";
        }

        if($this->fb_id){
            return "https://graph.facebook.com/{$this->fb_id}/picture?width=310&height=310#v=1.0";
        }

        return asset('placeholder/user.jpg');
    }

    
    /**
     * Get the devices for this user.
     */
    public function devices() {
        return $this->hasMany("App\Laravel\Models\UserDevice", "user_id");
    }

    /**
     * Get the devices for this user.
     */
    public function specialty() {
        return $this->hasOne('App\Laravel\Models\Specialty','id','specialty_id');
    }

    /**
     * Get the facebook account for this user.
     */
    public function facebook() {
        return $this->hasOne("App\Laravel\Models\UserSocial", "user_id")->where('provider', "facebook");
    }

   
    /**
     * Search users that match a keyword.
     */
    public function scopeKeyword($query, $keyword = "") {
        return $query->where(function($query) use($keyword) {
            $query->WhereRaw("LOWER(email) = '{$keyword}'");
                // ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    public function scopeAccount_type($query,array $types){
        if(count($types) > 0){
            return $query->whereIn('type',$types);
        }
    }


    /**
     * Route notifications for the FCM channel.
     *
     * @return string
     */
    public function routeNotificationForFcm()
    {
        return $this->devices()->where('is_login', '1')->pluck('reg_id')->toArray() ?: 'user123';
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return array
     */
    public function receivesBroadcastNotificationsOn()
    {
        // return [
        //     new PrivateChannel("USER.{$this->id}"),
        // ];

        return "user.{$this->id}";
    }

    /**
     * Get user's avatar
     */
    public function getAvatar() {

        if($this->fb_id){
            return "https://graph.facebook.com/{$this->fb_id}/picture?width=310&height=310#v=1.0";
        }

        return asset('assets/img/avatar4.png');
    }


    public function scopeTypes($query,array $types){
        if(count($types) > 0){
            return $query->whereIn('type',$types);
        }
    }

}
