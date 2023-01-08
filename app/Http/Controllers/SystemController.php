<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DataTables;

# Custom Models
use App\Models\Role;
use App\Models\Log;
use App\Models\User;

class SystemController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:system-role', ['only' => ['role','roleDelete','roleShow','roleStore','roleEdit']]);
         $this->middleware('permission:system-log', ['only' => ['log','logDelete','logAllDelete']]);
    }

    public function role(Request $request){
        if($request->isMethod("GET")){

            $roles = Role::where('title','!=','Admin')->get();
            //dd($roles);
            return view("Settings.role",['roles'=>$roles]);
        }
    }
    public function roleDelete(Request $request , $id){
        if($request->isMethod("POST")){
            $role = Role::find($id);
            if($role){
                $role->delete();
                return redirect()->back()->with(session()->flash('success', 'Role Deleted !'));
            }
        }
    }
    public function roleShow(Request $request , $id){
        $role = Role::find($id);
        return $role;
    }
    public function roleStore(Request $request){
        if($request->isMethod("POST")){
            $data['title'] = $request->title;
            $data['slug'] = $request->slug;
            $validator = Validator::make($data, [
                'slug' => ['required', 'string', 'max:255'],
                'title' => ['required', 'string', 'max:255', 'unique:role,title'],
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{
                Role::create([
                    'title' =>  $data['title'],
                    'slug' =>   $data['slug'],
                ]);
                return redirect()->back()->with(session()->flash('success', 'Role Added!'));
            }
        }

    }
    public function roleEdit(Request $request, $id){
        if($request->isMethod("POST")){
            $role = Role::find($id);
            $data['title'] = $request->title_edit;
            $data['slug'] = $request->slug_edit;
            $validator = Validator::make($data, [
                'slug' => ['required', 'string', 'max:255'],
                'title' => ['required', 'string', 'max:255',],
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{
                $role->title = $data['title'];
                $role->slug = $data['slug'];
                $role->save();
                return redirect()->back()->with(session()->flash('success', 'Role Updated !'));
            }
        }
    }
    public function permission(Request $request, $id){
        if($request->isMethod("GET")){

            //dd($filteredRoutes);
            $role = Role::where('id',decrypt($id))->get();
            $permisson =  DB::table('permissions')->get();

            return view("Settings.permisson",['permisson'=>$permisson , 'role'=> $role ,]);
        }
    }
    public function log(Request $request){
       $allLog = Log::orderBy('created_at', 'ASC')->get();
       //dd($allLog);
       if($request->ajax()){
            return Datatables::of($allLog)
            ->editColumn('user_id', function(Log $value) {
                $user = User::find($value->user_id);
                return $user->name;
            })
            ->editColumn('created_at', function(Log $value) {
                return \Carbon\Carbon::parse($value->due_date)->format('d/m/Y');
            })
            ->removeColumn('updated_at')
            ->addColumn('action', function(Log $value){
                $btn ='<button data-id='.$value->id.' class="btn delete_btn" style="border:1px solid rgb(219, 219, 219); padding-right: .5rem;">'
                        .'<i data-id='.$value->id.' class="fas fa-trash-alt text-danger"></i>'
                    .'</button>';
                    return $btn;
            })
            ->rawColumns(['user_id','created_at','action'])
            ->make(true);
       }
       return view('Settings.log');
    }
    public function logDelete(Request $request, $id){
        if($request->ajax()){
            $log = Log::find($id);
            if($log){
                $log->delete();
                return response()->json(['msg'=>'success']);
            }else{
                return response()->json(['msg'=>'error']);
            }
        }else{
            return response()->json(['msg'=>'error']);
        }
    }
    public function logAllDelete(Request $request){
        if($request->ajax()){
            $log = Log::all();
            foreach($log as $value){
                $value->delete();
            }
            return response()->json(['msg'=>'success']);
        }else{
            return response()->json(['msg'=>'error']);
        }
    }
    public function permissionToggle(Request $request){
        if($request->ajax()){

            #use revoke and give permission here



            // $rolePermisson = DB::table('role_has_permissions')->where('permission_id',$request->permission_id)->where('role_id',$request->role_id)->get();
            // if(count($rolePermisson) != 0){
            //     DB::table('role_has_permissions')->where('permission_id',$request->permission_id)->where('role_id',$request->role_id)->delete();
            //     return response()->json(['msg'=>'Permission revoked']);
            // }else{
            //     DB::table('role_has_permissions')->insert([
            //         'permission_id' => $request->permisson_id,
            //         'role_id'=>$request->role_id,
            //     ]);
            //     return response()->json(['msg'=>'Permission given']);
            // }

        }
    }
}
