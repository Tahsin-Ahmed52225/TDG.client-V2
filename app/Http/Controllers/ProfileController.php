<?php

namespace App\Http\Controllers;

use App\Helper\LogActivity;
use Illuminate\Http\Request;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Custom Model
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $user = auth()->user();
            return view('Common.profile', ['user' => $user]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = auth()->user();
        if($request->isMethod("GET")){
            return view('common.edit_profile', ['user' => $user]);
        }else if($request->isMethod("POST")){
            $user = User::find(auth()->user()->id);
            $data['name'] = $request->userName;
            $data['email'] = (isset($request->adminEmail)) ? $request->adminEmail : $user->email; ;
            $data['phone'] = $request->userNumber;
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', new PhoneNumber],
            ]);
            if(Auth::user()->email !=  $data['email']){
                $validator = Validator::make($data, [
                    'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                ]);
            }
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)
                ->withInput();
            }else{
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                $user->save();
                LogActivity::addToLog($user->name." updated profile info");
                return redirect()->back()->with(session()->flash('alert-success', 'Profile successfully updated'));
            }
        }
    }
    public function ChangePassword(Request $request){
        $user = auth()->user();
        if($request->isMethod("GET")){
            return view('common.change_password', ['user' => $user]);
        }else{
            $data['password'] = $request->userPassword;
            $validator = Validator::make($data, [
                'password' => ['required', 'string', 'min:6'],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)
                ->withInput();
            }else{
                $user->password = Hash::make($request->userPassword);
                $user->save();
                LogActivity::addToLog($user->name." changed password");
                return redirect()->back()->with(session()->flash('alert-success', 'Password successfully changed'));
            }
        }
    }
    public function changeProfilePic(Request $request){
        if($request->isMethod("POST")){
            if ($request->file("profile_avatar")) {
                $file = $request->file("profile_avatar");
                $fileName =  preg_replace("/\h*/", "_", $file->getClientOriginalName());
                $file->move("files/profile_pics", $fileName);
                $user = Auth::user();
                $user->image = $fileName;
                $user->save();
                LogActivity::addToLog($user->name." changed profile picture");
                return redirect()->back()->with(session()->flash('alert-success', 'Image uploaded successfully updated'));

            }else{
                return redirect()->back()->with(session()->flash('alert-warning', 'Choose a image to upload'));
            }
        }
    }
}
