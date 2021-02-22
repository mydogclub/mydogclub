<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Image;

use App\Gallery;
use App\User;
use App\Comment;
use Config;

class GalleryController extends Controller
{
    //
    public function index()
    {
    	$gallery = Gallery::select('*')->orderBy('id', 'desc')->paginate(Config::get('settings.gallery_page_size'));
        foreach($gallery as $item){
        $item->url = asset('image/gallery').'/my-dog-club-'.$item->alias.'-'.$item->img;
        }
    	return view('gallery', compact('gallery'));
    }

    public function show($alias)
    {
    	$gallery = Gallery::select('*')->where('alias', $alias)->first();
        if (empty($gallery)) {
        return view('errors.404', ['error'=>'Ошибка 404!!! Страница удалена или не существует']);
        }
        $gallery->increment('counter');
        $commentCount = Comment::select('id')
        ->where('type', 'gallery')
        ->where('source_id', $gallery->id)        
        ->count();
        $gallery->url = asset('image/gallery').'/my-dog-club-'.$gallery->alias.'-'.$gallery->img;       
    	return view('galleryShow', compact('gallery', 'commentCount'));
    }

    public function showUser($user_id)
    {
        $gallery = Gallery::select('*')->where('user_id',$user_id)->orderBy('id', 'desc')->paginate(Config::get('settings.gallery_page_size'));
        $showUser = User::select('name')->where('id',$user_id)->first();
        foreach($gallery as $item){
        $item->url = asset('image/gallery').'/my-dog-club-'.$item->alias.'-'.$item->img;
        }
        return view('gallery', compact('gallery','showUser'));
    }
    public function showTitle($title)
    {
        $str = str_replace('_', '\_', $title);
        $gallery = Gallery::select('*')->where('alias','LIKE','%'.$str.'%')->orderBy('id', 'desc')->paginate(Config::get('settings.gallery_page_size'));
        $showTitle = '';
        foreach($gallery as $item){
        $showTitle = $item->title;
        $item->url = asset('image/gallery').'/my-dog-club-'.$item->alias.'-'.$item->img;
        }
        return view('gallery', compact('gallery','showTitle'));
    }

    public function upload(Request $request)
    {
        $this->validate($request, 
        [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',//'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024'
        'title' => 'required|string|max:255',
        'text'=> 'max:1000',
        ],
        [
        'image.required' => 'Не выбран файл изображения',
        'image.image'=> 'Выбранный файл не является файлом изображения',
        'image.mimes'=> 'Неверный формат файла, допустимые форматы: jpeg,png,jpg,gif',
        'image.max' => 'Недопустимый размер файла, не более 1 Мб',
        'title.required' => 'Поле  "Заголовок"  не должно быть пустым.',
        'title.string' => 'Поле  "Заголовок" должно быть строкового типа',
        'title.max' => 'Поле  "Заголовок"  не должно превышать 255 символов',        
        'text.max' => 'Поле  "Описание"  не должно превышать 1000 символов',
        ]
    );        
            $file = $request->file('image');
            $input = $request->all();           
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            // 1024 x 768; 200 x 150; 60 x 45            
            $oldName = public_path($destinationPath.DIRECTORY_SEPARATOR.$file->getClientOriginalName()); 
            $t = time();
            
            $gallery = new Gallery;
            $gallery->alias= $t;
            $gallery->title = $input['title'];
            $gallery->text = strip_tags(trim($input['text']));
            $gallery->user_id = $input['user_id'];

            $gallery->keywords = implode(', ', explode(" ", $input['title']));
            $gallery->img = $t;
            $gallery->save();
            
            $gallery->alias = str_slug($input['title'], '_');
            $gallery->alias .= '_'.$gallery->id;
            $gallery->save();
            
            $str = $gallery->alias;
            $newName = 'image'.DIRECTORY_SEPARATOR.'gallery'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t;                       
            $l = public_path($newName.'path.jpg');
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');

            Image::img_resize($oldName,$l,800,600,'',0x222222);
            Image::img_resize($oldName,$m,200,150,'',0x222222);
            Image::img_resize($oldName,$s,60,45,'',0x222222);
            unlink($oldName);
            
            
            return redirect('/gallery');

    }
    
}