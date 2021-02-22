<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qa_category extends Model
{
    //   
    protected $table = 'qa_categories';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
    
}