<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

# Custom models
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectSubtask;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectSubtaskAssigns;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->isMethod("GET")){
            #Handling the card info
            # User Info
            $Employees['total'] = count(User::where('role_id','!=',1)->get());
            $Employees['active'] = count(User::where('role_id','!=',1)->where('stage',1)->get());
            $Employees['locked'] = count(User::where('role_id','!=',0)->where('stage',1)->get());
            # Project Info
            $Projects['total'] = count(Project::where('id','!=',1)->get());
            $Projects['running'] = count(Project::where('id','!=',1)->where('status','running')->get());
            $Projects['hold'] = count(Project::where('id','!=',1)->where('status','stopped')->get());
            $Projects['complete'] = count(Project::where('id','!=',1)->where('status','complete')->get());
            #Global Tasks table
            $userAssigned = User::where('id','!=', 1)->get();
            $tasks = ProjectSubtask::where("project_id", 1)->orderBy('due_date', 'DESC')->get();
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
            return view("Admin.dashboard", ['userAssigned' => $userAssigned , 'employees' => $Employees , 'projects' => $Projects]);
        }else{

        }

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
}
