<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

use App\Category;

use App\User;

use App\Comment;

use Config;

class DevelopmentsController extends Controller
{
    //
    public function index(){
    	$cat_id = Category::select('id')->where('alias', 'developments')->first();
    	$developments = Article::select('*')->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->paginate(Config::get('settings.developments_page_size'));
         foreach ($developments as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/developments').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
    	return view('developments', compact('developments'));
    }

    public function show($alias){
    	$developments = Article::select('*')->where('alias', $alias)->first();
        if (empty($developments)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $developments->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'article')
        ->where('source_id', $developments->id)        
        ->count();
        $developments->url = asset('image/developments').'/'.'my-dog-club-'.str_slug($developments->title, '-').'-'.$developments->img;        
    	return view('developmentsShow', compact('developments','commentCount'));
    }

    public function showUser($user_id){
    	$cat_id = Category::select('id')->where('alias', 'developments')->first();
        $developments = Article::select('*')->where('user_id',$user_id)->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->paginate(Config::get('settings.developments_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        foreach ($developments as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/developments').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
        return view('developments', compact('developments','showUser'));
    }
    
}
