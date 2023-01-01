<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
     /**
     * login user and direct to user dashboard
     *
     * @return to_user_dashboard
     */
    public function index(Request $request){
        if ($request->isMethod("GET")) {
            return  view("Guest.login");
        } else if ($request->isMethod("POST")) {
            $data['email'] = $request->email;
            $data['password'] = $request->password;
            $validator = Validator::make($data, [
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ]);
            if ($validator->fails()) {
                return redirect("/login")
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (Auth::attempt(['email' =>  $request->email, 'password' => $request->password])) {
                    if (Auth::user()->stage == 1) {
                         return redirect('/'.Auth::user()->role->slug.'/dashboard');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with(session()->flash('alert-warning', 'Your account has been locked !'));
                    }
                } else {
                    return redirect()->back()->with(session()->flash('alert-danger', 'Incorract Credentials'));
                }
            }
        } else {
            return  view('welcome');
        }

    }
    /**
     * logout user
     *
     * @return to_login_page
     */
    public function logout(){
        if(Session::get('session-hop')){
            Auth::loginUsingId(decrypt(Session::get('session-hop')));
            Session::forget('session-hop');
            return redirect('../'.Auth::user()->role->slug.'/dashboard');
        }else{
            Auth::logout();
        }
        return redirect('/login');

    }

}
