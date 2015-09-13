<?php namespace App\Http\Controllers\Mall;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{

    public function getLogin()
    {
        return view('mall.auth.login');
    }



    public function getUnauthorized()
    {
        return view('mall.auth.login');
    }

    public function getLogout()
    {
        // Logs the user out
        Auth::logout();
        return redirect('/');
    }

    public function postLogin()
    {

        if (Auth::check()) {
            return redirect('/');
        }
    
        $rules = array(
            'email'     => 'required|email',
            'password'  => 'required',
        );

        $validation = Validator::make(Input::all(), $rules);

        if ($validation->fails()) {
            return redirect('auth')->withErrors($validation)->withInput();
        }
        
        $email      = Input::get('email');
        $password   = Input::get('password');
   
        if (Auth::attempt(['email' => $email, 'password' => $password, 'activated' => 1])) {
            return redirect()->intended('user');
        }
        $errors = new Illuminate\Support\MessageBag;
        $errors->add('invalid', "Oops, your email or password is incorrect.");

        return redirect('login')->withErrors($errors)->withInput();
    }
}
