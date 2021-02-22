<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //   
    protected $table = 'qa_answers';
    protected $fillable = [
        'user_id', 'question_id', 'body',
    ];
public function user()
    {  
    return $this->belongsTo('App\User')->select('*');
    }
public function question()
    {  
    return $this->belongsTo('App\Question')->select('*');
    } 
}

