<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

use App\Category;

use App\User;

use App\Comment;

use Config;

class BlogController extends Controller
{
    //
    //public $seo = [
    //	'title' => 'Блог'
    //];

    public function index(){
    	$cat_id = Category::select('id')->where('alias', 'blog')->first();
    	$blog = Article::select('*')->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->paginate(Config::get('settings.blog_page_size'));
            foreach ($blog as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/blog').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
    	return view('blog', compact('blog'));
    }

    public function show($alias){
    	$blog = Article::select('*')->where('alias', $alias)->first();
        if (empty($blog)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $blog->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'article')
        ->where('source_id', $blog->id)        
        ->count();
        $blog->url = asset('image/blog').'/'.'my-dog-club-'.str_slug($blog->title, '-').'-'.$blog->img;
    	return view('blogShow', compact('blog','commentCount'));
    }

    public function showUser($user_id){
    	$cat_id = Category::select('id')->where('alias', 'blog')->first();
        $blog = Article::select('*')->where('user_id',$user_id)->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->paginate(Config::get('settings.blog_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        foreach ($blog as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/blog').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
        return view('blog', compact('blog','showUser'));
    }
   
}
