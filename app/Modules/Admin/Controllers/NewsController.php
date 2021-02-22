<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

use App\Http\Image;

use App\Article;

use App\Category;

use App\User;

use Config;

class NewsController extends Controller

{

public function index()
{  
  $cat_id = Category::select('id')
  ->where('alias', 'news')
  ->first();
    if (Gate::allows('Moderator')) {
    $news = Article::select('id', 'title')
    ->where('category_id', $cat_id['id'])
    ->where('user_id', auth()->id())
    ->orderBy('id', 'desc')
    ->paginate(Config::get('settings.news_page_size_admin'));
  }
  else{
  $news = Article::select('id', 'title')
  ->where('category_id', $cat_id['id'])
  ->orderBy('id', 'desc')
  ->paginate(Config::get('settings.news_page_size_admin'));
     }
      return view('Admin::news', compact('news'));

}
public function show($id)
{  
  $item = Article::select('*')
  ->find($id);
  return view('Admin::newsShow', compact('item'));
}

public function create()
{  
  $news = new Article;
  $news->choices = 'news';
  $cat = Category::select('id')
  ->where('alias', 'news')
  ->first();
  $news->category_id = $cat->id;
  $news->user_id = auth()->id();/* Тут указать id пользователя создающего статью*/
  $news->img = 'placeholder';
  $news->save();
  return redirect('/admin/news/show/'.$news->id);
  //return view('Admin::newsShow', ['item' => $news]);
}

 public function update(Request $request){  
   $input = $request->all();
   $news = Article::where('id', $input['id'])->first();
   if(empty($news))return redirect('/admin/news')->with('status', 'Не удалось обновить');
   $news->title = $input['title'];
   $news->text = $input['text'];
   $news->description = $input['desc'];
   $news->alias = str_slug($input['title'], '_');   
   $news->keywords = (empty($input['keywords']))? '':$input['keywords'];   
    if($news->save()){
       $str = "news";
       Image::imageRename($str, $news->img, $news->title);   
   }         
   return redirect()->back();
 }

 public function upload(Request $request){  
  $this->validate($request, 
        [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',        
        ]        
    );        
            $file = $request->file('image');
            $input = $request->all();
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            // 1024 x 768; 200 x 150; 60 x 45            
            $oldName = public_path($destinationPath.DIRECTORY_SEPARATOR.$file->getClientOriginalName()); 
            $t = time();
            $news = Article::where('id', $input['id'])->first();
            $str = str_slug($news->title, "-");
            $newName = 'image'.DIRECTORY_SEPARATOR.'news'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t;
                       
            $l = public_path($newName.'path.jpg');
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');

            Image::img_resize($oldName,$l,800,600);
            Image::img_resize($oldName,$m,300,225);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);                                    
            $news->img = $t;
            $news->save();
            $newName = 'image'.DIRECTORY_SEPARATOR.'news'.DIRECTORY_SEPARATOR.$input['img'];
            if($newName !=="placeholder"){
            if(is_file(public_path($newName.'path.jpg')))
            unlink(public_path($newName.'path.jpg'));
            if(is_file(public_path($newName.'max.jpg')))
            unlink(public_path($newName.'max.jpg'));
            if(is_file(public_path($newName.'mini.jpg')))
            unlink(public_path($newName.'mini.jpg'));
            }   
            //return redirect('/admin/news');
            return redirect()->back();

 }

 public function destroy($id)
 {         
         $news = Article::where('id', $id)->first();
         if($news->img != 'placeholder'){
         $str = str_slug($news->title, "-");
         $newName = 'image'.DIRECTORY_SEPARATOR.'news'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$news->img;         
          if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
             }   
         $news->delete();
         return redirect('/admin/news');
 }

}