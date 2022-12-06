<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            if($request->userName == "" || $request->userNumber = ""){
                return redirect()->back()->with('warning', "Field cann't be blank");
            }else{
                $user->name = $request->userName;
                $user->phone = $request->userNumber;
                $user->save();
                return redirect()->back()->with('success', "Profile updated");
            }
        }
    }
    public function ChangePassword(Request $request){
        $user = auth()->user();
        if($request->isMethod("GET")){
            return view('common.change_password', ['user' => $user]);
        }else{
            $user->password = Hash::make($request->userPassword);
            $user->save();
            return redirect()->back()->with('success', "Password Changed");
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
                    return redirect()->route("edit_profile")->with("success", "Profile Updated Succesfully");

            }
        }
    }
}
