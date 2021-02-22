<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //   
    protected $table = 'qa_questions';
    protected $fillable = [
        'user_id', 'qa_category_id', 'title', 'content',
    ];
public function user()
    {  
    return $this->belongsTo('App\User')->select('*');
    }
public function answers()
    {  
    return $this->hasMany('App\Answer', 'question_id', 'id');
    }
}

