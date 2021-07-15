<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Session;

class AuthenticationController extends BaseController
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    

    function login(Request $request){ 
        if (Auth::guard('admin')->user()) {
            return redirect("/admin");
        }
        return view('admin.auth.login');
    }
    function logout(Request $request){ 
        Auth::guard('admin')->logout();
        Session::flash('success-logout', 'Logout Success!');
        return redirect(route('login'));
    }
    public function postLogin(Request $request) {
        $rules = [
            'email' =>'required',
            'password' => 'required|min:6'
        ];
        $messages = [
            'email.required' => 'メールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => '6文字以上のパスワードを入力してください。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        
        if ($validator->fails()) {
            return redirect(route('login'))->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $password = $request->input('password');
     
            if( Auth::guard('admin')->attempt(['email' => $email, 'password' =>$password])) { 
                return redirect('/admin');
            } else {
                Session::flash('error', 'メールアドレスまたはパスワードが不正です。');
                return redirect(route('login'));
            }
        }
    }
}