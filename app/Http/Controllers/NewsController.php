<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

use App\Category;

use App\User;

use App\Comment;

use Config;

class NewsController extends Controller
{
    //
    public function index(){
    	$cat_id = Category::select('id')->where('alias', 'news')->first();
    	$news = Article::select('*')->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->paginate(Config::get('settings.news_page_size'));
         foreach ($news as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/news').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
    	return view('news', compact('news'));
    }

    public function show($alias){
    	$news = Article::select('*')->where('alias', $alias)->first();
        if (empty($news)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $news->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'article')
        ->where('source_id', $news->id)        
        ->count();
        $news->url = asset('image/news').'/'.'my-dog-club-'.str_slug($news->title, '-').'-'.$news->img;        
    	return view('newsShow', compact('news', 'commentCount'));
    }

    public function showUser($user_id){
    	$cat_id = Category::select('id')->where('alias', 'news')->first();
        $news = Article::select('*')->where('user_id',$user_id)->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->paginate(Config::get('settings.news_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        foreach ($news as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/news').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
        return view('news', compact('news','showUser'));
    }
    
}
