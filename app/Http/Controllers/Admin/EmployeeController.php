<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

// Custom Model
use App\Models\User;
use App\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->isMethod("GET")) {
            $roles = Role::all();
            $users = User::where('role_id','!=',1)->get();
            //dd($users);
            return view('Admin\Empolyee\index', ['users' => $users , 'roles' =>$roles]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod("GET")) {
            $roles = Role::all();
            return view('Admin\Empolyee\create', ['roles' => $roles]);
        } else if ($request->isMethod("POST")) {
            $data['name'] = $request->tdg_name;
            $data['email'] = $request->tdg_email;
            $data['phone'] = $request->tdg_phone;
            $data['role'] = $request->tdg_position;
            $data['password'] = $request->tdg_password;
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'phone' => ['required', 'string', 'max:255'],
                'position' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
            ]);
            if ($validator->fails()) {
                return redirect("/admin/add-member")
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $token = sha1(time());
                $user = User::create([
                    'name' =>  $data['name'],
                    'email' =>   $data['email'],
                    'number' => $data['phone'],
                    'position' => '-',
                    'role' =>  $data['role'],
                    'verification_code' => $token,
                    'stage' => 1,
                    'password' => Hash::make($request->password),
                ]);
                if ($user != null) {
                    return redirect()->back()->with(session()->flash('alert-success', 'Member Added !'));
                } else {
                    return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong, Try Again !'));
                }
            }
        } else {

            return redirect('/');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $user = User::find($request->id);
            if ($request->value == null) {
                $msg = ucwords($request->option) . " shouldn't be empty";
                Session::flash('error', $msg);
                return View::make('Common/partials/flash_message');
            } else {
                if ($request->option == "email") {
                    if (filter_var($request->value, FILTER_VALIDATE_EMAIL)) {
                        if ($user) {
                            $option = $request->option;
                            $user->$option =  filter_var($request->value, FILTER_SANITIZE_EMAIL);
                            $user->save();
                            $msg = ucwords($request->option) . " updated successfully";
                            Session::flash('success', $msg);
                            return View::make("Common/partials/flash_message");
                        } else {
                            Session::flash('error', "Something went wrong");
                            return View::make("Common/partials/flash_message");
                        }
                    } else {
                        Session::flash('error', "Enter valid email");
                        return View::make("Common/partials/flash_message");
                    }
                } else if ($request->option == "number") {
                    if (filter_var($request->value, FILTER_VALIDATE_INT)) {
                        if ($user) {
                            $option = $request->option;
                            $user->$option =  filter_var($request->value, FILTER_VALIDATE_INT);
                            $user->save();
                            $msg = ucwords($request->option) . " updated successfully";
                            Session::flash('success', $msg);
                            return View::make("Common/partials/flash_message");
                        } else {
                            Session::flash('error', "Something went wrong");
                            return View::make("Common/partials/flash_message");
                        }
                    } else {
                        Session::flash('error', "Incorrect input");
                        return View::make("Common/partials/flash_message");
                    }
                } else {
                    if ($user) {
                        $option = $request->option;
                        $user->$option =  $request->value;
                        $user->save();
                        $msg = ucwords($request->option) . " updated successfully";
                        Session::flash('success', $msg);
                        return View::make("Common/partials/flash_message");
                    } else {
                        Session::flash('error', "Something went wrong");
                        return View::make("Common/partials/flash_message");
                    }
                }
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $user = User::find($request->data);
            if ($user) {
                $user->delete();
                Session::flash('success', 'Member removed successfully');
                return View::make('Common/partials/flash_message');
            } else {
                Session::flash('error', 'Something is wrong');
                return View::make('Common/partials/flash_message');
            }
        } else {
            return redirect('/');
        }
    }
}
