<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Category;

class Article extends Model
{
    //
    //protected $dateFormat = 'd-m-Y H:i:s';

    public function user()
    {  
    return $this->belongsTo('App\User')->select('id', 'name');
    } 
    public function category()
    {  
    return $this->belongsTo('App\Category');
    } 

    
}