<?php
namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\Profile;
use App\Contact;
use App\Http\Image;

class IndexController extends Controller

{

public function index()
{     
 $users = User::select('id','name','email','ban','verified','role')->get();	
 return view('Admin::index', compact('users'));
}

public function setRole(Request $request)
{  
  $input = $request->all();
  $user = User::where('id', $input['user_id'])->first();
  $user->role = $input['value'];
  $user->save();
  return redirect('/admin/user');

}

public function setBan(Request $request)
{  
  $input = $request->all();
  $user = User::where('id', $input['user_id'])->first();
  $user->ban = $input['value'];
  $user->save();
  return redirect('/admin/user');

}
public function setVerified(Request $request)
{  
  $input = $request->all();
  $user = User::where('id', $input['user_id'])->first();
  $user->verified = 1;
  $user->save();
  $profile = new Profile;
  $profile->user_id = $user->id;
  $profile->name = $user->name;
  $profile->save();
  return redirect('/admin/user');
}
public function deleteUser(Request $request)
{  
  $input = $request->all();
  $user = User::where('id', $input['user_id'])->first();    
  DB::table('profile')->where('user_id', $user->id)->delete();
  DB::table('comments')->where('user_id', $user->id)->delete();
  $galleries = DB::table('galleries')->where('user_id', $user->id)->get();
  if ($galleries->count()!==0) {
     foreach ($galleries as $item) {
       $img = $item->img;
       $newName = 'image'.DIRECTORY_SEPARATOR.'gallery'.DIRECTORY_SEPARATOR.$img;
       if(is_file(public_path($newName.'path.jpg')))
            unlink(public_path($newName.'path.jpg'));
       if(is_file(public_path($newName.'max.jpg')))
            unlink(public_path($newName.'max.jpg'));
       if(is_file(public_path($newName.'mini.jpg')))
            unlink(public_path($newName.'mini.jpg'));
     }
   } 
  DB::table('galleries')->where('user_id', $user->id)->delete();

  $articles = DB::table('articles')->where('user_id', $user->id)->get();
  if ($articles->count()!==0) {
     foreach ($articles as $item) {
       $img = $item->img;
       $newName = 'image'.DIRECTORY_SEPARATOR.$item->choices.DIRECTORY_SEPARATOR.$img;
       if(is_file(public_path($newName.'path.jpg')))
            unlink(public_path($newName.'path.jpg'));
       if(is_file(public_path($newName.'max.jpg')))
            unlink(public_path($newName.'max.jpg'));
       if(is_file(public_path($newName.'mini.jpg')))
            unlink(public_path($newName.'mini.jpg'));
     }
   } 
  DB::table('articles')->where('user_id', $user->id)->delete();
  DB::table('messages')->where('from_id', $user->id)->orWhere('to_id', $user->id)->delete();
  $user->delete(); 
  return redirect('/admin/user');
}
public function edit($id){
    $profile = Profile::where('user_id', $id)->first();
    $contact = Contact::where('user_id', $id)->first();
    return view('Admin::user', compact('profile', 'contact'));
}
public function update(Request $request){
    $data = $request->all();
    unset($data['_token']);
    $user_id = $data['user_id'];
    unset($data['user_id']);
    $id = $data['id'];
    unset($data['id']);
    $model = $data['model'];
    unset($data['model']);
    switch($model){
    case 'Profile': Profile::where('id', $id)->update($data);break;
    case 'Contact': Contact::where('id', $id)->update($data);break;
    }    
    return redirect('/admin/user/edit/'.$user_id);
}
public function avatarUpdate(Request $request)
{
$this->validate($request, 
        [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',       
        ],
        [
        'image.required' => 'Не выбран файл изображения',
        'image.image'=> 'Выбранный файл не является файлом изображения',
        'image.mimes'=> 'Неверный формат файла, допустимые форматы: jpeg,png,jpg,gif',
        'image.max' => 'Недопустимый размер файла, не более 1 Мб',      
        ]
    );            
            $data = $request->all();          
            $user_id = $data['user_id'];
            $id = $data['id'];
            $file = $request->file('image');            
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            // 1024 x 768; 200 x 150; 60 x 45            
            $oldName = public_path($destinationPath.DIRECTORY_SEPARATOR.$file->getClientOriginalName());
            $t = time();
            $newName = 'image'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR.$t;           
            $l = public_path($newName.'.png');

            Image::img_resize($oldName,$l,200,200);
            
            unlink($oldName);
            $profile = Profile::where('id', $id)->first();
            $tmp = $profile->avatar;                       
            $profile->avatar = $t.'.png';
            $profile->save();
            if ($tmp!=='avatar.png') {
                $newName = 'image'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR.$tmp;
               if(is_file(public_path($newName)))
                     unlink(public_path($newName)); 
            }
                       
            return redirect('/admin/user/edit/'.$user_id)->with('personalMes', 'Профиль успешно обновлен');
}
}