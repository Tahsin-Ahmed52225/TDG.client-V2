<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helper\LogActivity;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectFiles;
use Illuminate\Http\Request;
use App\Models\ProjectAssigns;

class SingleProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getProjectAssignDetails(Request $request){
        if($request->ajax()){
            $assign_data = ProjectAssigns::where('id',$request->id)
                    ->get();

            if($assign_data[0]->Project->manager_id != $assign_data[0]->user->id){
                $buttons = '<div class="col-6 text-center">'.
                                '<form method="GET" action="'.route("project.remove_member", $assign_data[0]->id).'">'
                                   . '<button type="submit"'
                                       . 'class="btn btn-lg btn-danger"'
                                        .'name="member_id"'
                                        .'value='.$assign_data[0].
                                                '<i class="fas fa-minus-circle"></i>'
                                        .'Remove Member</button>'
                                .'</form>'
                            .'</div>';
                if ($assign_data[0]->Project->manager_id == null){
                    $buttons = $buttons.'<div class="col-6 text-center">'.
                            '<form method="GET" action="'.route("project.assign_manager", [$assign_data[0]->user_id, $assign_data[0]->project_id] ).'">'
                               . '<button type="submit"'
                                   . 'class="btn btn-lg btn-primary"'
                                    .'name="member_id"'
                                    .'value='.$assign_data[0].
                                            '<i class="fas fa-minus-circle"></i>'
                                    .'Make Manager</button>'
                            .'</form>'
                        .'</div>';

                }else{
                    $buttons = $buttons.'<div class="col-6 text-center">'.
                    '<form method="GET" action="'.route("project.assign_manager",[$assign_data[0]->user_id, $assign_data[0]->project_id]).'">'
                       . '<button type="submit"'
                           . 'class="btn btn-lg btn-primary"'
                            .'name="member_id"'
                            .'value='.$assign_data[0].
                                    '<i class="fas fa-minus-circle"></i>'
                            .'Change Manager</button>'
                    .'</form>'
                .'</div>';

                }

            }else{
                $buttons = '<div class="col-md-6 text-center">'.
                                '<form method="GET" action="'.route("project.remove_manager", $assign_data[0]->project_id).'">'
                                   . '<button type="submit"'
                                       . 'class="btn btn-lg btn-danger"'
                                        .'name="member_id"'
                                        .'value='.$assign_data[0].
                                                '<i class="fas fa-minus-circle"></i>'
                                        .'Remove Manager</button>'
                                .'</form>'
                            .'</div>';
            }
            $data = ['name'=>$assign_data[0]->user->name, 'position'=>$assign_data[0]->user->position->title, 'info'=>$assign_data[0] , 'buttons'=>$buttons];
            return $data;
        }
    }
    public function removeMember($id){
       $data = ProjectAssigns::find($id);
       if($data){
            $project = Project::find($data->project_id);
            $user = User::find($data->user_id);
            LogActivity::addToLog($user->name." has been removed from : ".$project->title);
            $data->delete();
            return redirect()->back()->with(session()->flash('alert-success', 'Project member removed successfully'));
       }

    }
    public function removeManager($id){
        dd($id);
    }
    public function assignManager($user_id, $project_id){
      $project = Project::find($project_id);
      if($project){
        $project->manager_id = $user_id;
        $user = User::find($user_id);
        $project->save();
        LogActivity::addToLog($project->title." project manager assigned to : ".$user->name);
        return redirect()->back()->with(session()->flash('alert-success', 'Project manager assigned'));
      }else{
        return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
      }
    }

    public function addFile(Request $request ,$id){
        $data["file_description"] = $request->file_description;
        $data["file"] = $request->file("project_file");
        $fileName = $data["file"]->getClientOriginalName();
        $data["file"]->move("files/project".$id, $fileName);

        $validator = Validator::make($data, [
            'file_description' => ['required'],
            'file' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }else{
            $new_file = ProjectFiles::create([
                'description' => $data["file_description"],
                'file_path' => $fileName,
                'project_id'=> $id,
                'user_id'=> Auth::user()->id,
            ]);
            return redirect()->back()->with(session()->flash('alert-success', 'Project file added successfully!'));
        }
    }
}
