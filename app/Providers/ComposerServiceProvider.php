<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

use App\Menu;

use App\Gallery;

use App\Category;

use App\Article;

use App\Keeping;

use App\Poll;

use App\Message;

use App\Qa_category;

use App\Question;

use App\Answer;

use Config;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
View::composer('*', function($view) 
{
    $menuitems = Menu::select('*')->ofSort(['parent' => 'asc'])->get();

    $menuitems = $this->buildTree($menuitems);

    $sideGalleries = Gallery::select('*')->orderBy('counter', 'desc')->limit(Config::get('settings.gallery_port_count'))->get();
    foreach ($sideGalleries as $item){                
                $item->url = asset('image/gallery').'/'.'my-dog-club-'.$item->alias.'-'.$item->img;
            }
                                          
    $cat_id = Category::select('id')->where('alias', 'blog')->first();
    $sideBlogs = Article::select('*')->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->limit(Config::get('settings.blog_port_count'))->get();
    foreach ($sideBlogs as $item){                
                $item->url = asset('image/blog').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }

    $cat_id = Category::select('id')->where('alias', 'news')->first();
    $sideNews = Article::select('*')->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->limit(Config::get('settings.news_port_count'))->get();
    foreach ($sideNews as $item){                
                $item->url = asset('image/news').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }

    $cat_id = Category::select('id')->where('alias', 'developments')->first();
    $sideDevelopments = Article::select('*')->where('category_id', $cat_id['id'])->orderBy('id', 'desc')->limit(Config::get('settings.developments_port_count'))->get();
    foreach ($sideDevelopments as $item){                
                $item->url = asset('image/developments').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
    $sideKeeping = Keeping::select('*')->orderBy('id', 'desc')->limit(1)->get();
        foreach ($sideKeeping as $item){               
                $item->url = asset('image/keeping').'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
            }
    if (auth()->check()) {
           $mes = Message::where('to_id', auth()->id())->where('status', 0)->count();
           if ($mes ==0) {
               $mesmes = false;
           }
           else{
            $mesmes = true;
           }
       }   
    else{
        $mesmes = false;
    }
    $poll = Poll::select('id')->orderBy('id', 'desc')->limit(1)->get();
    $pollId = $poll[0]->id;
    $view->with(['menuItems' => $menuitems,
                 'sideGalleries' => $sideGalleries,
                 'sideBlogs' => $sideBlogs,
                 'sideNews' => $sideNews,
                 'sideDevelopments' => $sideDevelopments,
                 'sideKeeping' => $sideKeeping,
                 'mesmes' => $mesmes,
                 'pollId' => $pollId
                ]);

 });
 View::composer('qa.app', function($view) 
{
  $category = Qa_category::select('*')->get();
  $last_answers = Answer::orderBy('id', 'DESC')->limit(5)->with('question')->get();
  $view->with([
               'category' => $category,
               'last_answers' => $last_answers
  ]);
});
    }
    public function buildTree($items)
    {
        $grouped = $items->groupBy('parent');

        foreach ($items as $item) {
            if ($grouped->has($item->id)) {
                $item->children = $grouped[$item->id];
            }
        }

        return $items;
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
