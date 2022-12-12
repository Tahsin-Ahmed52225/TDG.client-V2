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
        if($project){
            return view('project.single', ['project' => $project]);
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
