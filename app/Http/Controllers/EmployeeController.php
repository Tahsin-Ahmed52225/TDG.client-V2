<?php

namespace App\Http\Controllers;

use App\Helper\LogActivity;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;

// Custom Model
use App\Models\User;
use App\Models\Role;
use App\Models\Position;


class EmployeeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:employee-manage', ['only' => ['index','create','update','destroy','employeeLogin']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , $stage=null)
    {
        if ($request->isMethod("GET")) {
            if($stage == 'active'){
                $title = "Active";
                $users = User::where('role_id','!=',1)->where('stage',1)->get();
            }else if($stage == "locked"){
                $title = "Locked";
                $users = User::where('role_id','!=',1)->where('stage',0)->get();
            }else{
                $title = "All";
                $users = User::where('role_id','!=',1)->get();
            }
            $roles = Role::all();
            $position = Position::all();
            return view('Admin\Empolyee\index', ['users' => $users , 'roles' =>$roles,'positions' =>$position,'title'=>$title]);
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
            $position = Position::all();
            return view('Admin\Empolyee\create', ['roles' => $roles,'positions' =>$position]);
        } else if ($request->isMethod("POST")) {
            $data['name'] = $request->tdg_name;
            $data['email'] = $request->tdg_email;
            $data['phone'] = $request->tdg_phone;
            $data['role'] = $request->tdg_role;
            $data['position'] = $request->tdg_position;
            $data['password'] = $request->tdg_password;
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'phone' => ['required', new PhoneNumber],
                'role' => ['required'],
                'position' => ['required'],
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
                    'phone' => $data['phone'],
                    'position_id' => $data['position'],
                    'role_id' =>  $data['role'],
                    'verification_code' => $token,
                    'stage' => 1,
                    'password' => Hash::make($request->password),
                ]);
                if ($user != null) {
                    LogActivity::addToLog("New Member Added");
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
                return response()->json(["data" => 'error','msg' =>  $msg]);
            } else {
                if ($request->option == "email") {
                    if (filter_var($request->value, FILTER_VALIDATE_EMAIL)) {
                        if ($user) {
                            $option = $request->option;
                            $user->$option =  filter_var($request->value, FILTER_SANITIZE_EMAIL);
                            $user->save();
                            $msg = ucwords($request->option) . " updated successfully";
                            LogActivity::addToLog( $user->name." : ".$msg);
                            return response()->json(["data" => $msg]);
                        } else {
                            return response()->json(["data" => 'error' ,'msg' => 'Something went wrong']);
                        }
                    } else {
                            return response()->json(["data" => 'error','msg' => 'Enter valid email address']);
                    }
                } else if ($request->option == "phone") {
                    if ($request->value) {
                        if ($user) {
                            $option = $request->option;
                            $user->$option =  $request->value;
                            $user->save();
                            $msg = ucwords($request->option) . " updated successfully";
                            LogActivity::addToLog( $user->name." : ".$msg);
                            return response()->json(["data" => $msg]);
                        } else {
                            return response()->json(["data" => 'error','msg' => 'Something went wrong']);
                        }
                    } else {
                        return response()->json(["data" => 'error','msg' => 'Enter valid number']);
                    }
                } else {
                    if ($user) {
                        $option = $request->option;
                        $user->$option =  $request->value;
                        $user->save();
                        $msg = ucwords($request->option) . " updated successfully";
                        LogActivity::addToLog( $user->name." : ".$msg);
                        return response()->json(["data" => $msg]);
                    } else {
                        return response()->json(["data" => 'error','msg' => 'Enter valid email address']);
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
    public function employeeLogin(Request $request){
        if ($request->ajax()) {
            Session::put('session-hop', encrypt(Auth::user()->id));
            Auth::loginUsingId($request->user_id);
            $user = User::where('id',$request->user_id)->first();
            $URL = '../'.$user->role->slug.'/dashboard';
            return response()->json(['data' =>$request->user_id, 'url'=>$URL]);
        }
    }
}
