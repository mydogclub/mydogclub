<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Contact;
use App\Message;
use App\Profile;
use App\Http\Image;
use Hash;

class IndexController extends Controller

{	

public function index()

{
 $profile = auth()->user()->profile;
 return view('Dashboard::index', compact('profile'));

}
public function edit(Request $request)
{
 $profile = auth()->user()->profile;
 $profile->name = empty($request->name) ? auth()->user()->name : $request->name;
 $profile->profession = empty($request->profession) ? '' : $request->profession;
 $profile->address = empty($request->address) ? '' : $request->address;
 $profile->age = ($request->age<0) ? 0 : $request->age;
 $profile->pets = empty($request->pets) ? '' : $request->pets;
 $profile->save();
 return redirect('/dashboard')->with('personalMes', 'Профиль успешно обновлен');

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
            $profile = auth()->user()->profile;
            $tmp = $profile->avatar;                       
            $profile->avatar = $t.'.png';
            $profile->save();
            if ($tmp!=='avatar.png') {
                $newName = 'image'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR.$tmp;
               if(is_file(public_path($newName)))
                     unlink(public_path($newName)); 
            }
                       
            return redirect('/dashboard')->with('personalMes', 'Профиль успешно обновлен');
}
public function contactsShow()
{
	$profile = auth()->user()->profile;
	$contact = auth()->user()->contacts;	
    return view('Dashboard::contacts', compact('profile', 'contact'));
}

public function contactsEdit(Request $request)
{//echo "<pre>"; print_r($request->all()); exit();
	$contact = auth()->user()->contacts;
	$contact->phone1 = $request->phone1;
	$contact->phone2 = $request->phone2;
	$contact->phone3 = $request->phone3;
	$contact->skype = $request->skype;
	$contact->viber = $request->viber;
	$contact->telegram = $request->telegram;
	$contact->email = $request->email;
	$contact->facebook = $request->facebook;
	$contact->instagram = $request->instagram;
	$contact->twitter = $request->twitter;
	$contact->vk = $request->vk;
	$contact->ok = $request->ok;	
	$contact->whatsapp = $request->whatsapp;
	$contact->save();
	return redirect('/dashboard/contacts')
	->with('contactsMes', 'Контакты успешно обновлены');
}

public function changePasswordShow()
{
	$profile = auth()->user()->profile;
	return view('Dashboard::changePassword', compact('profile'));
}

public function changePasswordEdit(Request $request)
{
	$validator = Validator::make($request->all(), [	  
      'newPassword' => 'required|string|min:6|confirmed',
    ]);      
      if (!Hash::check($request->password, auth()->user()->password))
{   
    return redirect('/dashboard/changePassword')
    ->with('changePasswordError', 'Неверный пароль');
}

    if ($validator->fails()) {
      return redirect('/dashboard/changePassword')
      ->with('changePasswordError', 'Неверный ввод');
    }
    $user = auth()->user();
    $user->password = bcrypt($request->newPassword);
    $user->save();
    return redirect('/dashboard/changePassword')
    ->with('changePasswordMes', 'Пароль успешно изменен');
}

public function privateMessagesShow()
{
    $profile = auth()->user()->profile;
    $messages = Message::select('*')
    ->where('to_id', auth()->id())
    ->get();    
    $messages = $messages
    ->keyBy('from_id');             
    return view('Dashboard::privateMessages', compact('profile', 'messages'));
}
public function privateMessagesUser($id)
{
    $profile = auth()->user()->profile;
    $messages = Message::where(function($query) use($id)
        {
          $query->where('to_id', auth()->id())
          ->where('from_id', $id);
        })->orWhere(function($query) use($id)
        {
            $query->where('to_id', $id)->where('from_id', auth()->id());
        })->orderBy('id', 'desc')->paginate(12);
    $user = User::find($id);

        Message::where(function($query) use($id)
        {
          $query->where('to_id', auth()->id())
          ->where('from_id', $id);
        })
        ->update(['status' => 1]);

    return view('Dashboard::privateMessagesUser', compact('profile', 'messages', 'user'));
}

public function privateMessagesSend(Request $request)
{   
    $validator = Validator::make($request->all(), [   
      'message' => 'required|string|min:6',
    ]); 
    if ($validator->fails()) {
      return redirect()->back()
      ->with('privateMesError', 'Неверный ввод');
    }
    $mes = new Message();
    $mes['from_id'] = auth()->id();
    $mes['to_id'] = $request->to_id;
    $mes['status'] = 0;
    $mes['message'] = $request->message;
    $mes->save();
    return redirect('/dashboard/privateMessagesUser/'.$request->to_id)->with('privateMes', 'Сообщение отправленно');

}




}