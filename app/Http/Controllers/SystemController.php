<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

# Custom Models
use App\Models\Role;

class SystemController extends Controller
{
    public function role(Request $request){
        if($request->isMethod("GET")){

            $roles = Role::all();
            //dd($roles);
            return view("Settings.role",['roles'=>$roles]);
        }
    }
    public function roleDelete(Request $request , $id){
        if($request->isMethod("POST")){
            $role = Role::find($id);
            if($role){
                $role->delete();
                return redirect()->back()->with(session()->flash('alert-success', 'Role Deleted !'));
            }
        }
    }
    public function roleShow(Request $request , $id){
        $role = Role::find($id);
        return $role;
    }
    public function roleEdit(Request $request, $id){
        if($request->isMethod("POST")){
            $role = Role::find($id);
            $data['title'] = $request->title;
            $data['slug'] = $request->slug;
            $validator = Validator::make($data, [
                'slug' => ['required', 'string', 'max:255'],
                'title' => ['required', 'string', 'max:255', 'unique:roles,title'],
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
                return redirect()->back()->with(session()->flash('alert-success', 'Role Updated !'));

            }

        }
    }

}
