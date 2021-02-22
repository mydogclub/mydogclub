<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Breed;

use App\Disease;

use App\Article;

use App\Category;

use App\User;

use App\Comment;

use Config;

use Illuminate\Mail\Mailable;

use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    public function dogsShow()
    {
       $breeds = Breed::select('title', 'alias')->orderBy('title', 'asc')->get();
       $diseases = Disease::select('title', 'alias')->orderBy('letter', 'asc')->get();
       return view('dogsShow', compact('breeds', 'diseases'));
    }
    public function sendMessage(Request $request)
    {
      $this->validate($request, 
        [
        'email' => 'required|string|email|max:255',
        'title' => 'required|string|max:255',
        'msg'=> 'required|string|max:1000',        
        ],
        [        
        'title.required' => 'Поле  "Тема"  не должно быть пустым.',
        'title.string' => 'Поле  "Тема" должно быть строкового типа',
        'title.max' => 'Поле  "Тема"  не должно превышать 255 символов',        
        'msg.max' => 'Поле  "Сообщение"  не должно превышать 1000 символов',
        'msg.required' => 'Поле  "Сообщение"  не должно быть пустым.',
        'msg.string' => 'Поле  "Сообщение" должно быть строкового типа',
        'email' => 'Неправильно введен адрес электронной почты',
        ]
    );
         $input = $request->all();
         $email = $input['email'];
         $title = $input['title'];
         $msg = $input['msg'];
         Mail::send('emails.contactMessage', compact('email', 'title', 'msg'), function ($message) {        
         $message->from('admin@my-dog.club', 'Сообщение с сайта my-dog.club');
         $message->subject('Сообщение с сайта my-dog.club');
         $message->to('admin@my-dog.club');
                      });
      return redirect('/contacts')->with('goodMsg', 'Собщение отправлено');
    }
    public function showTag($tag){
        $tag = trim($tag);        
        $article = Article::select('*')->where('keywords','LIKE','%'.$tag.'%')->orderBy('id', 'desc')->paginate(Config::get('settings.article_page_size'));        
        foreach ($article as $item){
                $count = Comment::where('source_id', $item->id)->where('type', 'article')->count();
                $item->comments = $count;
                $item->url = asset('image/'.$item->category->alias).'/'.'my-dog-club-'.str_slug($item->title, '-').'-'.$item->img;
                $item->route = $item->category->alias.'Show';
            }        
        return view('article', compact('article', 'tag'));
        
    }
}
