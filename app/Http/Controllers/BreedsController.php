<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Breed;
use App\User;
use App\Comment;
use Config;

class BreedsController extends Controller
{
 public function index()
 {
 	$letters = Breed::select('letter')
        ->orderBy('letter', 'asc')                
 	->get()
 	->keyBy('letter');               
 	return view('breeds', compact('letters'));
 }
 public function listBreeds(Request $request)
 {
 	$breeds = Breed::select('img', 'title', 'alias')->where('letter', $request->letter)->orderBy('title', 'asc')->get();
        foreach ($breeds as $item){                
                $item->url = asset('image/breeds').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
    return view('widget.listBreed', compact('breeds'));
 }
 public function show($alias){
    	$breeds = Breed::select('*')
    	->where('alias', $alias)
    	->first();
        if (empty($breeds)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $breeds->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'breed')
        ->where('source_id', $breeds->id)        
        ->count();
        $breeds->url = asset('image/breeds').'/'.'my-dog-club-'.str_slug($breeds->title, '-').'-'.$breeds->img;        
    	return view('breedsShow', compact('breeds', 'commentCount'));
    }
  public function showUser($user_id)
    {
        $breeds = Breed::select('*')->where('user_id',$user_id)->orderBy('id', 'desc')->paginate(Config::get('settings.breed_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        return view('breed', compact('breed','showUser'));
    }
    public function showTag($tag){
        $tag = trim($tag);        
        $breeds = Breed::select('*')->where('keywords','LIKE','%'.$tag.'%')->orderBy('id', 'desc')->paginate(Config::get('settings.breed_page_size'));       
        foreach ($breeds as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'breed')->count();
                $item->comments = $count;
                $item->url = asset('image/breeds').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;                
            }        
        return view('breed', compact('breeds'));
    
        
    }

}