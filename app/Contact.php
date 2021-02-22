<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Contact extends Model
{     
    public $timestamps = false;
	protected $table = 'contacts';
	protected $fillable = [
        'user_id', 'phone1', 'phone2', 'phone3','skype', 'viber', 'telegram', 'email', 'facebook', 'instagram', 'twitter', 'ok', 'vk', 'web', 'whatsapp'
    ];
    
}