<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];    

     public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function profile()
  {
    $profile = $this->hasOne('App\Profile');
    
    return $profile;
  }

  public function contacts()
  {
    $contact = $this->hasOne('App\Contact');
    
    return $contact;
  }
  public function comments()
  {
    $comments = $this->hasMany('App\Comment');
    return $comments;
  }   
}