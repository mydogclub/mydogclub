<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{   
	public $timestamps = false;
	protected $table = 'profile';
	protected $fillable = [
        'name', 'avatar', 'user_id', 'profession', 'address', 'age', 'pets'
    ];
}