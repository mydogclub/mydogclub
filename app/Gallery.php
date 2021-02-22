<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Gallery extends Model
{
    //
    public function filter(){
    	return $this->belongsTo('Dog\Filter', 'filter_alias', 'alias');
    }

    public function user()
    {  
    return $this->belongsTo('App\User')->select('id', 'name');
    }




}
