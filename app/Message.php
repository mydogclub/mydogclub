<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Message extends Model
{
	 protected $fillable = [
        'from_id', 'to_id', 'status','message',
    ];
    public $timestamps = false;
	protected $table = 'messages';
	public function user()
	{
		return $this->hasOne('App\User', 'id', 'from_id');
	}
    
}