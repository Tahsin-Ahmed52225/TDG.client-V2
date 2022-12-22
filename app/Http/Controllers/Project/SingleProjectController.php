<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helper\LogActivity;
use App\Helper\ProjectHelp;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectFiles;
use Illuminate\Http\Request;
use App\Models\ProjectAssigns;
use App\Models\ProjectSubtask;
use App\Models\ProjectSubtaskAssigns;

class SingleProjectController extends Controller
{

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
            LogActivity::addToLog("'".$user->name."' has been removed from : '".$project->title."'");
            $data->delete();
            return redirect()->back()->with(session()->flash('alert-success', 'Project member removed successfully'));
       }

    }
    public function removeManager(Request $request,$id){
        if($request->isMethod("GET")){
            $project = Project::find($id);
            if($project){
                $project->manager_id = null;
                $project->save();
                return redirect()->back()->with(session()->flash('alert-success', 'Project manager removed'));
            }else{
                return redirect()->back()->with(session()->flash('alert-warning', 'Project not found'));
            }
        }else{
            return redirect()->back()->with(session()->flash('alert-warning', 'Method not allowed'));
        }
    }
    public function assignManager($user_id, $project_id){
      $project = Project::find($project_id);
      if($project){
        $project->manager_id = $user_id;
        $user = User::find($user_id);
        $project->save();
        LogActivity::addToLog("'".$project->title."' project manager assigned to : '".$user->name."'");
        return redirect()->back()->with(session()->flash('alert-success', 'Project manager assigned'));
      }else{
        return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
      }
    }

    public function addFile(Request $request ,$id){
        $data["file_description"] = $request->file_description;
        $data["file"] = $request->file("project_file");


        $validator = Validator::make($data, [
            'file_description' => ['required'],
            'file' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }else{
            $fileName = $data["file"]->getClientOriginalName();
            $data["file"]->move("files/project".$id, $fileName);
            $new_file = ProjectFiles::create([
                'description' => $data["file_description"],
                'file_path' => $fileName,
                'project_id'=> $id,
                'user_id'=> Auth::user()->id,
            ]);
            $project = Project::find($id);
            LogActivity::addToLog("'".$new_file->file_path."' added to project: '".$project->title."'");
            return redirect()->back()->with(session()->flash('alert-success', 'Project file added successfully!'));
        }
    }

    public function getFile(Request $request, $id){
        if($request->ajax()){
            $project_file = ProjectFiles::find($id);
            if($project_file){
                return response()->json($project_file->toArray());
            }else{
                return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
            }
        }
    }

    public function editFile(Request $request , $id){
        $projecFile = ProjectFiles::find($id);
        if($projecFile){
            $projecFile->description = $request->file_description_edit;
            if($request->file("project_file_edit")){
                $file = $request->file("project_file_edit");
                $fileName =  $file->getClientOriginalName();
                $file->move("files/project".$id, $fileName);
                $projecFile->file_path = $fileName;
            }
            $projecFile->save();
            return redirect()->back()->with(session()->flash('alert-success', 'Project file updated successfully!'));
        }else{
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }

    public function deleteFile(Request $request , $file_id){
        if($request->isMethod('POST')){
            $file = ProjectFiles::find($file_id);
            if($file){
                LogActivity::addToLog($file->file_path." deleted from project: ".$file->project->title);
                $file->delete();
                return redirect()->back()->with(session()->flash('alert-success', 'Project file deleted successfully!'));
            }else{
                return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
            }
        }else{
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }
    public function createSubtask(Request $request , $id){
        if($request->ajax()){
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $data['priority'] = $request->priority;
            $data['due_date'] = $request->due_date;
            $data['assigned_member'] = $request->assigned_member;

            $validator = Validator::make($data, [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required'],
                'assigned_member' => ['required'],
                'priority' => ['string', 'max:255'],
                'due_date' => ['required','date'],
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator]);
            }else{
                $subtask = ProjectSubtask::create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'priority' => $data['priority'],
                    'due_date' => $data['due_date'],
                    'project_id' => $id
                ]);
                if($subtask){
                    foreach($data['assigned_member'] as $member){
                        ProjectSubtaskAssigns::create([
                            'project_subtask_id' => $subtask->id,
                            'user_id' => $member,
                        ]);
                    }
                    $project = Project::find($id);
                    LogActivity::addToLog("Task added to project: '".$project->title."'");
                    return response()->json(['data' => 'success']);
                  //  return redirect()->back()->with(session()->flash('alert-success', 'Subtask added successfully.'));
                }else{
                    return response()->json(['data' => 'error']);
                  // return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
                }


            }
        }else{
            return response()->json(['data' => 'error']);
        }
    }
    public function taskCompleteToggle(Request $request){
        if($request->ajax()){
            $task = ProjectSubtask::find($request->task_id);

            if($task){
                $task->complete = ($task->complete === 0) ? 1 : 0;
                $task->save();
                $stage = ($task->complete === 1) ? 'complete' : 'incomplete';
                LogActivity::addToLog( "'".$task->title."' marked : ".$stage);
                $project_progress = ProjectHelp::calculateProgressPercentage($task->project_id);
                return response()->json(['data' => $task->complete, 'project_progress'=> $project_progress]);
            }else{
                return response()->json(['data' => 'not found']);
            }
        }else{
            return response()->json(['data' => 'error']);
        }

    }
    public function deleteSubtask(Request $request, $id){
        if($request->ajax()){
            $task = ProjectSubtask::find($id);
            if($task){
                LogActivity::addToLog( "'".$task->title."' deleted from '".$task->project->title. "'");
                $task->delete();
                return response()->json(['data' => 'success']);
            }else{
                return response()->json(['data' => 'error']);
            }
        }
    }
    public function getSubtask(Request $request, $task_id){
        if($request->ajax()){
            $task = ProjectSubtask::find($task_id);
            $assigned_member = ProjectSubtask::where('project_subtask.id',$task_id)
                    ->join('project_subtask_user_assign','project_subtask_user_assign.project_subtask_id','project_subtask.id')
                    ->pluck('project_subtask_user_assign.user_id')->toArray();
            if($task){
                return response()->json(['data' => $task,'assigned_member'=> $assigned_member, 'msg'=>'Success']);
            }else{
                return response()->json(['msg'=>'Subtask not found']);
            }
        }
    }
    public function updateSubtask(Request $request, $task_id){
        if($request->ajax()){
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $data['priority'] = $request->priority;
            $data['due_date'] = $request->due_date;
            $data['assigned_member'] = $request->assigned_member;

            $validator = Validator::make($data, [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required'],
                'assigned_member' => ['required'],
                'priority' => ['string', 'max:255'],
                'due_date' => ['required','date'],
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator]);
            }else{
                $subtask = ProjectSubtask::find($task_id);
                $subtask->title = $data['title'];
                $subtask->description = $data['description'];
                $subtask->priority = $data['priority'];
                $subtask->due_date = $data['due_date'];
                $subtask->save();
                if($subtask){
                    ProjectSubtaskAssigns::where('project_subtask_id', $task_id)->delete();
                    foreach($data['assigned_member'] as $member){
                        ProjectSubtaskAssigns::create([
                            'project_subtask_id' => $subtask->id,
                            'user_id' => $member,
                        ]);
                    }
                    LogActivity::addToLog("Subtask Updated :'".$subtask->title."'");
                    return response()->json(['data' => 'success']);
                }else{
                    return response()->json(['data' => 'error']);
                }


            }
        }else{
            return response()->json(['data' => 'error']);
        }

    }
}
