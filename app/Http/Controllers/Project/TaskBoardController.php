<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ProjectHelp;
use App\Helper\LogActivity;
#
use App\Models\ProjectSubtask;
use Illuminate\Support\Facades\Auth;

class TaskBoardController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:taskboard-view', ['only' => ['index','changeStatus']]);
    }
    public function index(Request $request){
        if($request->ajax()){
            if(Auth::user()->role_id == 1){
                $tasks = ProjectSubtask::join('project_subtask_user_assign','project_subtask_user_assign.project_subtask_id','project_subtask.id')
                                ->orderBy('project_subtask.order','asc')
                                ->get(['project_subtask.id', 'project_subtask.complete','project_subtask.priority','project_subtask.due_date','project_subtask.title','project_subtask.description','project_subtask.status','project_subtask.project_id']);

            }else{
                $tasks = ProjectSubtask::join('project_subtask_user_assign','project_subtask_user_assign.project_subtask_id','project_subtask.id')
                                ->where('project_subtask_user_assign.user_id', Auth::user()->id)
                                ->orderBy('project_subtask.order','asc')
                                ->get(['project_subtask.id', 'project_subtask.complete','project_subtask.priority','project_subtask.due_date','project_subtask.title','project_subtask.description','project_subtask.status','project_subtask.project_id']);
            }


            $todo = ProjectHelp::taskformat($tasks, 'todo');
            $hold = ProjectHelp::taskformat($tasks, 'hold');
            $working = ProjectHelp::taskformat($tasks, 'working');
            $complete = ProjectHelp::taskformat($tasks, 'complete');
            return response()->json(['todo'=>$todo,'hold'=>$hold,'working'=>$working,'complete'=>$complete]);
        }
        return view('Project.taskboard');
    }
    public function changeStatus(Request $request){
        if($request->ajax()){
            $projectSubtask = ProjectSubtask::find($request->taskId);
            if($projectSubtask){
                ProjectHelp::taskReorder($request->dataValues);
                $projectSubtask->complete = ($request->status == 'complete') ? 1 : 0;
                $projectSubtask->status = $request->status;
                LogActivity::addToLog("'".Auth::user()->name."' changed '".$projectSubtask->title."' status to '".$projectSubtask->status."'");
                $projectSubtask->save();
                return response()->json(['status'=>'success']);
            }else{
                return response()->json(['status'=>'error']);
            }
        }else{
            return response()->json(['status'=>'error']);
        }
    }
}
