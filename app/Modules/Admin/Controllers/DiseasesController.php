<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Image;

use App\Disease;

use App\User;

use Config;

class DiseasesController extends Controller
{
	public function index()
	{	      
	    $diseases = Disease::select('id', 'title')    
	    ->orderBy('letter', 'asc')
	    ->paginate(Config::get('settings.breeds_page_size_admin'));
	    	return view('Admin::diseases', compact('diseases'));
	}

	public function show($id)
	{    
	  $item = Disease::select('*')
	  ->find($id);
     $files = array();
     if (is_dir('image/diseases/'.$id)) {
       $files = scandir('image/diseases/'.$id);
       unset($files[0]);
       unset($files[1]);      
     }
	  return view('Admin::diseasesShow', compact('item', 'files'));
	}

	public function create()
	{    
	  $diseases = new Disease;	  
	  $diseases->user_id = 1;/* Тут указать id пользователя создающего статью*/
	  $diseases->img = 'placeholder';
	  $diseases->save();
	  return redirect('/admin/diseases/show/'.$diseases->id);	 
	}

 public function update(Request $request){
   //$this->check();$this->check("moderator");
   $input = $request->all();
   $diseases = Disease::where('id', $input['id'])->first();
   if(empty($diseases))return redirect('/admin/diseases')->with('status', 'Не удалось обновить');
   $diseases->title =  ucfirst($input['title']);
   $diseases->letter = mb_substr($diseases->title, 0, 1);
   $diseases->text = $input['text'];   
   $diseases->alias = str_slug($input['title'], '_');   
   $diseases->keywords = (empty($input['keywords']))? '':$input['keywords'];
   $diseases->description =  (empty($input['description']))? '':$input['description'];
   if($diseases->save()){
       $str = "diseases";
       Image::imageRename($str, $diseases->img, $diseases->title);   
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
            $diseases = Disease::where('id', $input['id'])->first();
            $str = str_slug($diseases->title, "-");
            $newName = 'image'.DIRECTORY_SEPARATOR.'diseases'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$t;
             
            
            $m = public_path($newName.'max.jpg');
            $s = public_path($newName.'mini.jpg');
            
            Image::img_resize($oldName,$m,650,450);
            Image::img_resize($oldName,$s,60,45);
            unlink($oldName);
                                
            $diseases->img = $t;
            $diseases->save();
            $newName = 'image'.DIRECTORY_SEPARATOR.'diseases'.DIRECTORY_SEPARATOR.$input['img'];
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
      $destinationPath = 'image'.DIRECTORY_SEPARATOR.'diseases'.DIRECTORY_SEPARATOR.$id;
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
         $diseases = Disease::where('id', $id)->first();
         if($diseases->img != 'placeholder'){
         $str = str_slug($diseases->title, "-");
         $newName = 'image'.DIRECTORY_SEPARATOR.'diseases'.DIRECTORY_SEPARATOR."my-dog-club-{$str}-".$diseases->img;         
            if(is_file(public_path($newName.'max.jpg'))){
            unlink(public_path($newName.'max.jpg'));}
            if(is_file(public_path($newName.'mini.jpg'))){
            unlink(public_path($newName.'mini.jpg'));}
             } 
         $dir = 'image'.DIRECTORY_SEPARATOR.'diseases'.DIRECTORY_SEPARATOR.$diseases->id;
         if(is_dir(public_path($dir))){
             $files = scandir($dir);
             foreach ($files as $file){
                 if($file!=="." && $file!=="..") unlink(public_path ($dir.DIRECTORY_SEPARATOR.$file));                    
             }
             rmdir(public_path($dir));
         }
         $diseases->delete();
         return redirect('/admin/diseases');         
 }
 public function deleteImage(Request $request){
     $url = $request->url;
     if(is_file(public_path($url))) unlink (public_path ($url));
     return response("", 200);
 }

}