<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){

        return view('auth.passwords.forgot');

    }

    public function restore(Request $request)
    {
        $user = User::select('*')->where('email', $request->email)->first();
        if (!$user) {
            return redirect('/forgot')->with(['error'=>'Пользователя с таким Email не существует']);
        }
         $password = $this->randomPassword();
         $user->password = bcrypt($password);
         $user->save();
         Mail::send('emails.ForgotPassword', compact('user', 'password'), function ($message) use ($user) {        
         $message->from('admin@my-dog.club', 'Восстановление пароля на сайте my-dog.clab');
         $message->subject('Восстановление пароля');
         $message->to($user->email);
                      });
          return redirect('/forgot')->with(['message'=>"Новый пароль отправлен на $user->email" ]); 

    }
    public function randomPassword($passwordLenght = 10)
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = '';
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $passwordLenght; $i++) {
        $n = rand(0, $alphaLength);
        $pass .= $alphabet[$n];
    }
    return $pass;
}


}
