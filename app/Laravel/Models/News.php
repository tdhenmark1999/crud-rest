<?php

namespace App\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use App\Laravel\Traits\DateFormatterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use DateFormatterTrait,SoftDeletes;

	protected $table = "news";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','linked_url','path' ,'file','directory'
    ];

    public $timestamps = true;

    public function author() {
        return $this->BelongsTo("App\Laravel\Models\User", "user_id", "id");
    }


}
