<?php

namespace App\Http\Controllers;

use App\Models\Permisson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

# Custom Models
use App\Models\Role;

class SystemController extends Controller
{
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
            $routeCollection = Route::getRoutes();
            $arr = [];

            foreach ($routeCollection as $value) {
                if (preg_match('/^\/?project/', $value->getName()) || preg_match('/^\/?settings/', $value->getName()) ) {
                    $arr[] = $value->getName();
                }
            }
            $filteredRoutes = array_unique($arr);
            //dd($filteredRoutes);
            $role = Role::where('id',decrypt($id))->get('title');
            $permisson = Permisson::where('role_id',decrypt($id));
            return view("Settings.permisson",['permisson'=>$permisson , 'role'=> $role , 'filteredRoutes'=>$filteredRoutes]);
        }
    }

}
