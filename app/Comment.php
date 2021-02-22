<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Comment extends Model
{
	protected $fillable = [
        'source_id', 'user_id', 'type', 'text', 'parent_id',
    ];

  public function user()
    {  
    return $this->belongsTo('App\User')->select('*');
    } 
}