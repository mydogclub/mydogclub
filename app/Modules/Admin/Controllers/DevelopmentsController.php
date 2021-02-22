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

class DevelopmentsController extends Controller

{

public function index()
{  
  $cat_id = Category::select('id')
  ->where('alias', 'developments')
  ->first();
  if (Gate::allows('Moderator')) {
    $developments = Article::select('id', 'title')
    ->where('category_id', $cat_id['id'])
    ->where('user_id', auth()->id())
    ->orderBy('id', 'desc')
    ->paginate(Config::get('settings.developments_page_size_admin'));
  }
  else{
  $developments = Article::select('id', 'title')
  ->where('category_id', $cat_id['id'])
  ->orderBy('id', 'desc')
  ->paginate(Config::get('settings.developments_page_size_admin'));
     }    
      return view('Admin::developments', compact('developments'));

}
public function show($id)
{  
  $item = Article::select('*')
  ->find($id);
  return view('Admin::developmentsShow', compact('item'));
}

public function create()
{  
  $developments = new Article;
  $developments->choices = 'developments';
  $cat = Category::select('id')
  ->where('alias', 'developments')
  ->first();
  $developments->category_id = $cat->id;
  $developments->user_id = auth()->id();/* Тут указать id пользователя создающего статью*/
  $developments->img = 'placeholder';
  $developments->save();
  return redirect('/admin/developments/show/'.$developments->id);
  //return view('Admin::developmentsShow', ['item' => $developments]);
}

 public function update(Request $request){
   $input = $request->all();
   $developments = Article::where('id', $input['id'])->first();
   if(empty($developments))return redirect('/admin/developments')->with('status', 'Не удалось обновить');
   $developments->title = $input['title'];
   $developments->text = $input['text'];
   $developments->description = $input['desc'];
   $developments->alias = str_slug($input['title'], '_');   
   $developments->keywords = (empty($input['keywords']))? '':$input['keywords'];   
   if($developments->save()){
       $str = "developments";
       Image::imageRename($str, $developments->img, $developments->title);   
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
            $developments = Article::where('id', $input['id'])->first();
            $str = str_slug($developments->title, "-");
            $newName = 'image'.DIRECTORY_SEPARATOR.'developments'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t;
                       
            $l = public_path($newName.'path.jpg');
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');

            Image::img_resize($oldName,$l,800,600);
            Image::img_resize($oldName,$m,300,225);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);
                              
            $developments->img = $t;
            $developments->save();
            $newName = 'image'.DIRECTORY_SEPARATOR.'developments'.DIRECTORY_SEPARATOR.$input['img'];
            if($newName !=="placeholder"){
            if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
            }   
            //return redirect('/admin/developments');
            return redirect()->back();

 }

 public function destroy($id)
 {
         $developments = Article::where('id', $id)->first();
         if($developments->img != 'placeholder'){
         $str = str_slug($developments->title, "-");
         $newName = 'image'.DIRECTORY_SEPARATOR.'developments'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$developments->img;         
          if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
             }         
         $developments->delete();
         return redirect('/admin/developments');         
 }
 }