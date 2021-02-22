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

class BlogController extends Controller

{

public function index()
{  
	$cat_id = Category::select('id')
	->where('alias', 'blog')
	->first();  
  $blog = Article::select('id', 'title')
  ->where('category_id', $cat_id['id'])
  ->orderBy('id', 'desc')
  ->paginate(Config::get('settings.blog_page_size_admin'));     
  return view('Admin::blog', compact('blog'));
}
public function show($id)
{  
  $item = Article::select('*')
  ->find($id);
  $files = array();
     if (is_dir('image/blog/'.$id)) {
       $files = scandir('image/blog/'.$id);
       unset($files[0]);
       unset($files[1]);      
     }
  return view('Admin::blogShow', compact('item', 'files'));
}

public function create()
{  
  $blog = new Article;
  $blog->choices = 'blog';
  $cat = Category::select('id')
  ->where('alias', 'blog')
  ->first();
  $blog->category_id = $cat->id;
  $blog->user_id = auth()->id();/* Тут указать id пользователя создающего статью*/
  $blog->img = 'placeholder';
  $blog->save();
  return redirect('/admin/blog/show/'.$blog->id);
  //return view('Admin::blogShow', ['item' => $blog]);
}

 public function update(Request $request){  
   $input = $request->all();
   $blog = Article::where('id', $input['id'])->first();
   if(empty($blog)){return redirect('/admin/blog')->with('status', 'Не удалось обновить');}
   $blog->title = $input['title'];   
   $blog->text = $input['text'];
   $blog->description = $input['desc'];
   $blog->alias = str_slug($input['title'], '_');   
   $blog->keywords = (empty($input['keywords']))? '':$input['keywords'];
   if($blog->save()){
       $str = "blog";
       Image::imageRename($str, $blog->img, $blog->title);   
   }      
   return redirect()->back();
 }

 public function upload(Request $request){  
   if (isset($request->mainPhoto)) {
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
            $blog = Article::where('id', $input['id'])->first();
            $str = str_slug($blog->title, "-");
            $newName = 'image'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t; 
            
            $l = public_path($newName.'path.jpg');
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');
            
            Image::img_resize($oldName,$l,800,600);
            Image::img_resize($oldName,$m,300,225);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);
                                
            $blog->img = $t;
            $blog->save();
            $newName = 'image'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR.$input['img'];
            if($newName !=="placeholder"){
            if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
            }            
   }else if (isset($request->otherPhotos)) {
      $id = $request->id;
      $destinationPath = 'image'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR.$id;
      if (!is_dir($destinationPath)) {
         mkdir($destinationPath);
      }
      foreach ($request->file() as $file) {            
            foreach ($file as $f) {
               $f->move('uploads',$f->getClientOriginalName());
               $oldName = public_path('uploads'.DIRECTORY_SEPARATOR.$f->getClientOriginalName());
               $newName = public_path($destinationPath.DIRECTORY_SEPARATOR.$f->getClientOriginalName());
               Image::img_resize($oldName,$newName,300,225);
               unlink($oldName);
            }
      }
   }
   return redirect()->back();
 }

 public function destroy($id)
 {
         $blog = Article::where('id', $id)->first();
         if($blog->img != 'placeholder'){
         $str = str_slug($blog->title, "-");
         $newName = 'image'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$blog->img;         
          if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
             }   
         $dir = 'image'.DIRECTORY_SEPARATOR.'blog'.DIRECTORY_SEPARATOR.$blog->id;
         if(is_dir(public_path($dir))){
             $files = scandir($dir);
             foreach ($files as $file){
                 if($file!=="." && $file!==".."){ unlink(public_path ($dir.DIRECTORY_SEPARATOR.$file));}                    
             }
             rmdir(public_path($dir));
         }
         $blog->delete();
         return redirect('/admin/blog');         
 }
 public function deleteImage(Request $request){
     $url = $request->url;
     if(is_file(public_path($url))){ unlink (public_path ($url));}
     return response("", 200);
 }

}