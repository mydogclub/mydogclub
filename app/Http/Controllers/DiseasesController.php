<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Disease;
use App\User;
use App\Comment;
use Config;

class DiseasesController extends Controller
{
 public function index()
 {
 	$letters = Disease::select('letter')
 	->get()
 	->keyBy('letter');
        $diseases = Disease::select('title', 'alias')->get();
        foreach ($diseases as $item){               
                $item->url = asset('image/diseases').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
 	return view('diseases', compact('letters', 'diseases'));
 }
 public function listDiseases(Request $request)
 {      $letters = Disease::select('letter')
 	->get()
 	->keyBy('letter');
        $diseases = Disease::select('title', 'alias')->where('letter', $request->letter)->get();
        foreach ($diseases as $item){               
                $item->url = asset('image/diseases').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
 	return view('diseases', compact('letters', 'diseases')); 	
 }
 public function show($alias){
    	$diseases = Disease::select('*')
    	->where('alias', $alias)
    	->first();
        if (empty($diseases)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $diseases->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'disease')
        ->where('source_id', $diseases->id)        
        ->count();
        $diseases->url = asset('image/diseases').'/'.'my-dog-club-'.str_slug($diseases->title, '-').'-'.$diseases->img;        
    	return view('diseasesShow', compact('diseases', 'commentCount'));
    }
  public function showUser($user_id)
    {
        $diseases = Disease::select('*')->where('user_id',$user_id)->orderBy('id', 'desc')->paginate(Config::get('settings.breed_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        return view('disease', compact('diseases','showUser'));
    }

}

