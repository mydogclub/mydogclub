<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Image;

use App\Gallery;

use Config;

class GalleryController extends Controller

{

public function index()

{  
	$gallery = Gallery::select('id', 'title', 'text','alias', 'img', 'keywords')
	->orderBy('id', 'Desc')
	->paginate(Config::get('settings.gallery_page_size_admin'));

     return view('Admin::gallery', compact('gallery'));

}
 public function update(Request $request){  
   $input = $request->all();
   $gallery = Gallery::where('id', $input['id'])->first();
   if(empty($gallery))return redirect('/admin/gallery')->with('status', 'Не удалось обновить');
   $gallery->title = $input['title'];
   $gallery->text = $input['text'];
   $gallery->alias = $input['alias'];
   $gallery->keywords = $input['keywords'];
   $gallery->save();
   return redirect('/admin/gallery');
 }

 public function upload(Request $request){  
 	$this->validate($request, 
        [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',        
        ]        
    );        
            $file = $request->file('image');
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            // 1024 x 768; 200 x 150; 60 x 45            
            $oldName = public_path($destinationPath.DIRECTORY_SEPARATOR.$file->getClientOriginalName()); 
            $t = time();
            $newName = 'image'.DIRECTORY_SEPARATOR.'gallery'.DIRECTORY_SEPARATOR.$t;           
            $l = public_path($newName.'path.jpg');
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');

            Image::img_resize($oldName,$l,800,600);
            Image::img_resize($oldName,$m,200,150);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);
            $gallery = new Gallery;
            $gallery->alias= ' ';
            $gallery->title = ' ';
            $gallery->text = ' ';
            $gallery->user_id = 1;

            $gallery->keywords = ' ';
            $gallery->img = $t;
            $gallery->save();
            return redirect('/admin/gallery');


 }

 public function destroy($id){         
         $gallery = Gallery::where('id', $id)->first();
         $str = $gallery->alias;
         $newName = 'image'.DIRECTORY_SEPARATOR.'gallery'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$gallery->img;
         if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
         $gallery->delete();
         return redirect('/admin/gallery');
 } 

}