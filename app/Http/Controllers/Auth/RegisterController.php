<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\VerifyUser;
use App\Profile;
use App\Contact;
use App\Mail\VerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name1' => 'required|string|max:255',
            'email1' => 'required|string|email|max:255|unique:users,email',
            'password1' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name1'],
            'email' => $data['email1'],
            'password' => bcrypt($data['password1']),
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));

        return $user;
    }
    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $profile = new Profile;
                $profile->user_id = $user->id;
                $profile->name = $user->name;
                $profile->save();
                $contact = new Contact;
                $contact->user_id = $user->id;
                $contact->email = $user->email;
                $contact->save();
                $status = "Ваш адрес электронной почты подтвержден. Теперь Вы можете войти.";
            }else{
                $status = "Ваш адрес электронной почты уже подтвержден. Теперь Вы можете войти.";
            }
        }else{
            return redirect('/home')->with('warning', "Извините, Ваш адрес электронной почты не идентифицирован.");
        }

        return redirect('/home')->with('status', $status);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/home')->with('status', 'Мы отправили Вам код активации. Проверьте свою электронную почту и нажмите на ссылку,'
                . ' чтобы подтвердить регистрацию.'
                . '<br>'
                . 'Если письмо не пришло, проверть папку <b class="text-danger">Cпам</b> и перемистие в папку <b class="text-danger">Входящие</b>');
    }
  





}
