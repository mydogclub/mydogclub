<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Keeping;
use App\User;
use App\Comment;
use Config;

class KeepingController extends Controller
{
 public function index()
 {
 	
        $keeping = Keeping::select('*')->orderBy('id', 'desc')->get();
        foreach ($keeping as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'keeping')->count();
                $item->comments = $count;
                $item->url = asset('image/keeping').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
 	return view('keeping', compact('keeping'));
 } 
 public function show($alias){
    	$keeping = Keeping::select('*')
    	->where('alias', $alias)
    	->first();
        if (empty($keeping)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $keeping->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'keeping')
        ->where('source_id', $keeping->id)        
        ->count();
        $keeping->url = asset('image/keeping').'/'.'my-dog-club-'.str_slug($keeping->title, '-').'-'.$keeping->img;        
    	return view('keepingShow', compact('keeping', 'commentCount'));
    }
  public function showUser($user_id)
    {
        $keeping = Keeping::select('*')->where('user_id',$user_id)->orderBy('id', 'desc')->paginate(Config::get('settings.breed_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        foreach ($keeping as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'keeping')->count();
                $item->comments = $count;
                $item->url = asset('image/keeping').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
        return view('keeping', compact('keeping','showUser'));
    }
    public function showTag($tag){
        $tag = trim($tag);        
        $keeping = Keeping::select('*')->where('keywords','LIKE','%'.$tag.'%')->orderBy('id', 'desc')->paginate(Config::get('settings.breed_page_size'));        
        foreach ($keeping as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'keeping')->count();
                $item->comments = $count;
                $item->url = asset('image/keeping').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;                
            }        
        return view('keeping', compact('keeping'));
        
    }

}

