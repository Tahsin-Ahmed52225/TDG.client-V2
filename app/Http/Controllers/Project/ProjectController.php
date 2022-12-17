<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helper\LogActivity;

# Custom Models
use App\Models\Project;
use App\Models\ProjectAssigns;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role->title){
            $projects = Project::all();
            return view('project.index',compact('projects'));
        }else{
            dd("Working on it");
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
            $record = Project::take(3)->orderBy('due_date', 'desc')->get();
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
                    LogActivity::addToLog("Project added");
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
    public function show($id)
    {
        $project = Project::find($id);
        $user = User::where('role_id','!=','1')->get(['id','name'])->toArray();
        $userAssigned = ProjectAssigns::where('project_id',$project->id)
                        ->join('users', 'users.id', '=', 'project_user_assign.user_id')
                        ->get(['users.id', 'users.name'])
                        ->toArray();
        $notAssignUser = array_diff(array_map('serialize',$user), array_map('serialize',$userAssigned));
        $notAssignUser = array_map('unserialize',$notAssignUser);
        if($project){
            return view('project.single', ['project' => $project, 'notAssignUser' => $notAssignUser]);
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
                $project->project_name = $request->project_name;
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
            LogActivity::addToLog( count(($data['member_list']))." member added to".$project->title);
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
