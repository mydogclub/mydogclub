<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Image;

use App\Keeping;

use App\User;

use Config;

class KeepingController extends Controller
{
	public function index()
	{	      
	    $keeping = Keeping::select('id', 'title')    
	    ->orderBy('letter', 'asc')
	    ->paginate(Config::get('settings.breeds_page_size_admin'));
	    	return view('Admin::keeping', compact('keeping'));
	}

	public function show($id)
	{    
	  $item = Keeping::select('*')
	  ->find($id);
     $files = array();
     if (is_dir('image/keeping/'.$id)) {
       $files = scandir('image/keeping/'.$id);
       unset($files[0]);
       unset($files[1]);      
     }
	  return view('Admin::keepingShow', compact('item', 'files'));
	}

	public function create()
	{    
	  $keeping = new Keeping;	  
	  $keeping->user_id = 1;/* Тут указать id пользователя создающего статью*/
	  $keeping->img = 'placeholder';
	  $keeping->save();
	  return redirect('/admin/keeping/show/'.$keeping->id);	 
	}

 public function update(Request $request){
   //$this->check();$this->check("moderator");
   $input = $request->all();
   $keeping = Keeping::where('id', $input['id'])->first();
   if(empty($keeping))return redirect('/admin/keeping')->with('status', 'Не удалось обновить');
   $keeping->title =  ucfirst($input['title']);
   $keeping->letter = mb_substr($keeping->title, 0, 1);
   $keeping->text = $input['text'];   
   $keeping->alias = str_slug($input['title'], '_');   
   $keeping->keywords = (empty($input['keywords']))? '':$input['keywords'];
   $keeping->description =  (empty($input['description']))? '':$input['description'];
   if($keeping->save()){
       $str = "keeping";
       Image::imageRename($str, $keeping->img, $keeping->title);   
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
            $keeping = Keeping::where('id', $input['id'])->first();
            $str = str_slug($keeping->title, "-");
            $newName = 'image'.DIRECTORY_SEPARATOR.'keeping'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t;
            
            $l = public_path($newName.'path.jpg');
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');
            
            Image::img_resize($oldName,$l,800,600);
            Image::img_resize($oldName,$m,650,450);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);
                                
            $keeping->img = $t;
            $keeping->save();
            $newName = 'image'.DIRECTORY_SEPARATOR.'keeping'.DIRECTORY_SEPARATOR.$input['img'];
            if($newName !=="placeholder"){
            if(is_file(public_path($newName.'path.jpg')))
            unlink(public_path($newName.'path.jpg'));
            if(is_file(public_path($newName.'max.jpg')))
            unlink(public_path($newName.'max.jpg'));
            if(is_file(public_path($newName.'mini.jpg')))
            unlink(public_path($newName.'mini.jpg'));
            }               
   }else if (isset($request->otherPhotos)) {
      $id = $request->id;
      $destinationPath = 'image'.DIRECTORY_SEPARATOR.'keeping'.DIRECTORY_SEPARATOR.$id;
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
         $keeping = Keeping::where('id', $id)->first();
         if($keeping->img != 'placeholder'){
         $str = str_slug($keeping->title, "-");
         $newName = 'image'.DIRECTORY_SEPARATOR.'keeping'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$keeping->img;         
          if(is_file(public_path($newName.'path.jpg'))){
            unlink(public_path($newName.'path.jpg'));}
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
             } 
         $dir = 'image'.DIRECTORY_SEPARATOR.'keeping'.DIRECTORY_SEPARATOR.$keeping->id;
         if(is_dir(public_path($dir))){
             $files = scandir($dir);
             foreach ($files as $file){
                 if($file!=="." && $file!=="..") unlink(public_path ($dir.DIRECTORY_SEPARATOR.$file));                    
             }
             rmdir(public_path($dir));
         }
         $keeping->delete();
         return redirect('/admin/keeping');         
 }
 public function deleteImage(Request $request){
     $url = $request->url;
     if(is_file(public_path($url))) unlink (public_path ($url));
     return response("", 200);
 }

}