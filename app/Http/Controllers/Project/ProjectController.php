<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DataTables;
use App\Helper\LogActivity;

# Custom Models
use App\Models\Project;
use App\Models\ProjectAssigns;
use App\Models\ProjectFiles;
use App\Models\ProjectSubtask;
use App\Models\ProjectSubtaskAssigns;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , $stage = null)
    {
        if($request->isMethod("GET")){
            if($stage == 'complete'){
                $projects = Project::where('id','!=',1)->where('status','complete')->get();
            }else if($stage == 'running'){
                $projects = Project::where('id','!=',1)->where('status','running')->get();
            }else if($stage == 'stopped'){
                $projects = Project::where('id','!=',1)->where('status','stopped')->get();
            }else{
                $projects = Project::where('id','!=',1)->get();
            }
            return view('project.index',['projects'=> $projects]);
        }else{
            return redirect()->back()->with(session()->flash('alert-warning', 'Method not allowed'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->isMethod("GET")){
            $employee = User::where('role_id','!=',1)->get();
            $record = Project::take(3)->where('id','!=',1)->orderBy('due_date', 'desc')->get();
            return view('project.create',['record' => $record,'employee' => $employee]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod("POST")){
            $data['title'] = $request->tdg_project_name;
            $data['created_by'] = Auth::user()->id;
            $data['due_date'] = $request->tdg_project_date;
            $data['assigned_member'] = $request->assignee_member;
            $data['status'] = $request->tdg_project_status;
            $data['priority'] = $request->tdg_project_priority;
            $data['description'] = $request->tdg_project_description;
            $data['type'] = $request->tdg_project_type;

            $validator = Validator::make($data, [
                'title' => ['required', 'string', 'max:255'],
                'due_date' => ['required', 'date', 'max:255'],
                'assigned_member' => ['required'],
                'status' => ['required', 'string', 'max:255'],
                'priority' => ['string', 'max:255'],
                'description' => ['required','string','max:500'],
                'type' => ['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                //validation fail redirection
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $record = Project::create([
                    'title' => $data['title'],
                    'created_by' => $data['created_by'],
                    'due_date' => $data['due_date'],
                    'status' =>  $data['status'],
                    'priority' => $data['priority'],
                    'description' => $data['description'],
                    'type' => $data['type'],
                ]);
                if($record){
                    foreach($data['assigned_member'] as $member){
                        ProjectAssigns::create([
                            'project_id' => $record->id,
                            'user_id' => $member,
                        ]);
                    }
                    LogActivity::addToLog("Project added: '".$record->title."'");
                    return redirect()->back()->with(session()->flash('alert-success', 'Project added successfully! '));
                }else{
                    return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
                }

            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $project = Project::find($id);
        #tasks
        $tasks = ProjectSubtask::where("project_id", $project->id)->orderBy('due_date', 'DESC')->get();
        $completedTask = count(ProjectSubtask::where("project_id", $project->id)->where('complete',1)->get());
        if($request->ajax()){
            return Datatables::of($tasks)
            ->addColumn('checkbox', function(ProjectSubtask $value) {
                $checked = ($value->complete == 1) ? 'checked' : '';
                return '<input class="task_checkbox" data-id='.$value->id.' type="checkbox"'.$checked.">";
            }, 1)
            ->addColumn('taskMember', function(ProjectSubtask $value) {
                $members = ProjectSubtaskAssigns::where('project_subtask_id', $value->id)->get();
                $taskMember="";
                foreach($members as $member){
                    $taskMember = $taskMember. '<span class="tool" data-tip="'. $member->user->name .' | '.$member->user->position->title .'">'
                                                    .'<i style="font-size: 25px;" class="far fa-user-circle mr-1"></i>'.
                                              '</span>';
                }
                return $taskMember;
            }, 3)
            ->editColumn('title', function(ProjectSubtask $value) {
                $style = ($value->complete == 1) ? 'line-through' : '';
                $badge = '<br><span class="badge badge-dark mr-2 mt-2">'.'Project: '.$value->project->title.'</span>';
                if($value->priority == "low"){
                    $badge = $badge.'<span class="badge badge-primary mr-2">'.$value->priority.'</span>';
                }else if($value->priority == "medium"){
                    $badge = $badge.'<span class="badge badge-warning mr-2">'.$value->priority.'</span>';
                }else{
                    $badge = $badge.'<span class="badge badge-danger mr-2">'.$value->priority.'</span>';
                }
                $badge = $badge.'<span class="badge badge-info">'.$value->status.'</span>';
                return '<span data-id='.$value->id.' class="project-title mr-2" style="cursor: pointer;text-decoration:'.$style.'" data-toggle="modal" data-target="#viewSubtask">' . $value->title . '</span>'. $badge;
            })
            ->editColumn('due_date', function(ProjectSubtask $value) {
                return \Carbon\Carbon::parse($value->due_date)->format('d/m/Y');
            })
            ->removeColumn('description')
            ->removeColumn('priority')
            ->removeColumn('status')
            ->removeColumn('complete')
            ->removeColumn('project_id')
            ->addColumn('action', function(ProjectSubtask $value){
                  $btn ='<button data-id='.$value->id.' class="btn edit_btn mr-2" style="border:1px solid rgb(219, 219, 219); padding-right: .5rem;" data-toggle="modal" data-target="#editSubtaskModal">'
                            .'<i data-id='.$value->id.' class="fas fa-edit text-info"></i>'
                         .'</button>';
                  $btn = $btn. '<button data-id='.$value->id.' class="btn delete_btn" style="border:1px solid rgb(219, 219, 219); padding-right: .5rem;" data-toggle="modal" data-target="#deleteTask">'
                         .'<i data-id='.$value->id.' class="fas fa-trash-alt text-danger"></i>'
                      .'</button>';
                    return $btn;
            })
            ->rawColumns(['checkbox','action','title','taskMember'])
            ->make(true);

        }
        # Project member data
        $user = User::where('role_id','!=','1')->get(['id','name'])->toArray();
        $userAssigned = ProjectAssigns::where('project_id',$project->id)
                        ->join('users', 'users.id', '=', 'project_user_assign.user_id')
                        ->get(['users.id', 'users.name'])
                        ->toArray();
        $notAssignUser = array_diff(array_map('serialize',$user), array_map('serialize',$userAssigned));
        $notAssignUser = array_map('unserialize',$notAssignUser);
        # Project file data
        $files = ProjectFiles::where('project_id',$project->id)->get();
        if($project && ($id != 1)){
            return view('project.single', ['project' => $project, 'notAssignUser' => $notAssignUser , 'files' => $files ,'userAssigned' => $userAssigned , 'tasks' => $tasks , 'completedTask' => $completedTask]);
        }else{
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request , $id)
    {
        $project = Project::find($id);
        if($project){
            $project->due_date = $request->tdg_project_date;
            $project->status = $request->tdg_project_status;
            $project->priority = $request->tdg_project_priority;
            $project->type = $request->tdg_project_type;
            $project->budget = $request->tdg_project_budget;
            $project->save();
            return redirect()->back()->with(session()->flash('alert-success', 'Project info updated successfully!'));
        }else{
            return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong!'));
        }

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
     /** AJAX request
     * updating project Name
     * @param Request
     * @return json::success_status
     *
     */
    public function updateTitle(Request $request)
    {
        if ($request->ajax()) {
            $project = Project::find($request->project_id);
            if ($project) {
                LogActivity::addToLog("Project Title- '".$project->title."' changed to '".$request->project_name."'");
                $project->title = $request->project_name;
                $project->save();
                return response()->json(["success" => true]);
            } else {
                return response()->json(["success" => false]);
            }
        }
    }
    /** AJAX request
     * updating project description
     * @param Request
     * @return json::success_status
     *
     */

    public function updateDescription(Request $request)
    {
        if ($request->ajax()) {
            $project = Project::find($request->project_id);
            if ($project) {
                LogActivity::addToLog( "'".$project->title."' description updated");
                $project->description = $request->project_description;
                $project->save();
                return response()->json(["success" => true]);
            } else {
                return response()->json(["success" => false]);
            }
        }
    }

    public function updateMember(Request $request , $project_id){
        $project = Project::find($project_id);
        $data["member_list"] = $request->tdg_assignee_member;
        $validator = Validator::make($data, [
            'member_list' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(session()->flash('alert-warning', 'Memeber field is required.'));
        }else{
            foreach($data['member_list'] as $member){
                ProjectAssigns::create([
                    'project_id' => $project_id,
                    'user_id' => $member,
                ]);
            }
            LogActivity::addToLog( count(($data['member_list']))." member added to '".$project->title."'");
            return redirect()->back()->with(session()->flash('alert-success', 'Memeber added successfully.'));

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request ,$id)
    {
        if($request->isMethod('POST')){
            $project = Project::find($id);
            if($project){
                LogActivity::addToLog($project->title." deleted");
                $project->delete();

                return redirect()->back()->with(session()->flash('alert-success', 'Project deleted successfully!'));
            }else{
                return redirect()->back()->with(session()->flash('alert-warning', 'Something went wrong'));
            }
        }
    }
}
