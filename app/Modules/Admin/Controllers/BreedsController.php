<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Image;

use App\Breed;

use App\User;

use Config;

class BreedsController extends Controller
{
	public function index()
	{	      
	    $breeds = Breed::select('id', 'title')    
	    ->orderBy('title', 'asc')
	    ->paginate(Config::get('settings.breeds_page_size_admin'));
	    	return view('Admin::breeds', compact('breeds'));
	}

	public function show($id)
	{    
	  $item = Breed::select('*')
	  ->find($id);
     $files = array();
     if (is_dir('image/breeds/'.$id)) {
       $files = scandir('image/breeds/'.$id);
       unset($files[0]);
       unset($files[1]);      
     }
	  return view('Admin::breedShow', compact('item', 'files'));
	}

	public function create()
	{    
	  $breeds = new Breed;	  
	  $breeds->user_id = 1;/* Тут указать id пользователя создающего статью*/
	  $breeds->img = 'placeholder';
	  $breeds->save();
	  return redirect('/admin/breeds/show/'.$breeds->id);	 
	}

 public function update(Request $request){
   //$this->check();$this->check("moderator");
   $input = $request->all();
   $breeds = Breed::where('id', $input['id'])->first();
   if(empty($breeds))return redirect('/admin/breeds')->with('status', 'Не удалось обновить');
   $breeds->title =  ucfirst($input['title']);
   $breeds->letter = mb_substr($breeds->title, 0, 1);
   $breeds->text = $input['text'];   
   $breeds->alias = str_slug($input['title'], '_');   
   $breeds->keywords = (empty($input['keywords']))? '':$input['keywords'];
   $breeds->description =  (empty($input['description']))? '':$input['description'];
   if($breeds->save()){
       $str = "breeds";
       Image::imageRename($str, $breeds->img, $breeds->title);   
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
            $breeds =Breed::where('id', $input['id'])->first();
            $str = str_slug($breeds->title, "-");
            $newName = 'image'.DIRECTORY_SEPARATOR.'breeds'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t;
            
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');
            
            Image::img_resize($oldName,$m,650,450);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);                                
            $breeds->img = $t;
            $breeds->save();
            $newName = 'image'.DIRECTORY_SEPARATOR.'breeds'.DIRECTORY_SEPARATOR.$input['img'];
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
      $destinationPath = 'image'.DIRECTORY_SEPARATOR.'breeds'.DIRECTORY_SEPARATOR.$id;
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
         $breeds = Breed::where('id', $id)->first();
         if($breeds->img != 'placeholder'){
         $str = str_slug($breeds->title, "-");
         $newName = 'image'.DIRECTORY_SEPARATOR.'breeds'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$breeds->img;          
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
             } 
         $dir = 'image'.DIRECTORY_SEPARATOR.'breeds'.DIRECTORY_SEPARATOR.$breeds->id;
         if(is_dir(public_path($dir))){
             $files = scandir($dir);
             foreach ($files as $file){
                 if($file!=="." && $file!=="..") unlink(public_path ($dir.DIRECTORY_SEPARATOR.$file));                    
             }
             rmdir(public_path($dir));
         }
         $breeds->delete();
         return redirect('/admin/breeds');         
 }
 public function deleteImage(Request $request){
     $url = $request->url;
     if(is_file(public_path($url))) unlink (public_path ($url));
     return response("", 200);
 }

}