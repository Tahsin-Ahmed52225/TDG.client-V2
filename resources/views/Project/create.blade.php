@extends('layouts.admin')

@section("links")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
<link rel="stylesheet" href="{{ asset("dev-assets/css/tooltip.css") }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<style>
    .select2-container{
        width: 100% !important;
    }
</style>



<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 0px">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Container-->
                    <div class="container">
                        @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>


                                    @if ($errors->has('email'))
                                    @endif
                                    </div>
                                @endforeach
                        @endif

                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                        @if(Session::has('alert-' . $msg))
                                            @if($msg == 'success')
                                                 <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>

                                            @else
                                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                            @endif
                                        @endif
                        @endforeach
                        <div class="card card-custom">
                            <div class="card-header">
                             <h3 class="card-title">
                               Add Projects
                             </h3>
                            </div>
                            <!--begin::Form-->
                            <form method="POST" action={{ route("project.store") }} enctype="multipart/form-data"  autocomplete="off">
                            @csrf
                             <div class="card-body">
                                 <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Project Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="tdg_project_name" id="project_name" required/>
                                    </div>

                                 </div>
                                 <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Assignee <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-multiple" name="assignee_member[]" multiple="multiple">
                                            @foreach ( $employee as $ele )
                                                <option value={{ $ele->id }}>{{ $ele->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Due Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="tdg_project_date" required/>
                                    </div>

                                 </div>
                                 <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleSelect1">Status <span class="text-danger">*</span></label>
                                        <select class="form-control"  name="tdg_project_status">
                                            <option value="todo" class="text-dark font-weight-bold">Todo</option>
                                            <option value="running" class="text-info font-weight-bold">Running</option>
                                            <option value="complete" class="text-success font-weight-bold">Complete</option>
                                            <option value="stopped" class="text-danger font-weight-bold">Stopped</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleSelect1">Priority<span class="text-danger">*</span></label>
                                        <select class="form-control"  name="tdg_project_priority" >
                                            <option value="high" class="text-danger font-weight-bold">  High</option>
                                            <option value="medium"  class="text-warning font-weight-bold">Medium</option>
                                            <option value="low" class="text-success font-weight-bold">Low</option>
                                        </select>
                                    </div>
                                 </div>

                                 <div class="form-group ">
                                    <label for="exampleSelect1">Project Type<span class="text-danger">*</span></label>
                                    <select id="project_type" class="form-control"  name="tdg_project_type" >
                                        <option value="rnd" class="text-danger font-weight-bold">R&D</option>
                                        <option value="inhouse"  class="text-warning font-weight-bold">In House</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-group mb-1">
                                        <label for="exampleTextarea">Description</label>
                                        <textarea class="form-control" rows="3" name="tdg_project_description"></textarea>
                                    </div>
                                </div>

                             </div>
                             <div class="card-footer">
                                    <button type="submit" id="submit_button" class="dropzone-upload btn btn-primary mr-2">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                             </div>
                            </form>
                            <!--end::Form-->
                           </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <!--begin::Container-->
                    <div class="container">
                        @foreach (['delete_msg', 'undoed'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                @if($msg == 'delete_msg')
                                    <p class="alert alert-info">{{ Session::get('alert-' . $msg) }} <button class="btn btn-info btn-sm "><a class="text-white" href="{{ route("manager.undo_Project", Session::get('id_value')) }}">Undo</a></button> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @elseif($msg == 'undoed')
                                <p class="alert alert-success">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
                            @endif
                        @endforeach
                        <div class="card card-custom">
                            <div class="card-header">
                                 <div class="card-title">
                                     <h3 >
                                        Recent Projects
                                    </h3>
                                 </div>

                                <div class="card-title">
                                    <a href="{{ route("project.view") }}">
                                          <button type="button" class="btn btn-primary btn-sm">View All</button>
                                    </a>
                                </div>
                            </div>
                            @foreach ( $record as $item)

                            <a href="{{ route('project.show', $item->id) }}">
                                <div class="card-body">
                                    <div class="card card-custom text-dark">
                                        <div class="card-header" >

                                            <div class="card-title pt-5 mt-3">
                                                <span class="card-icon">
                                                    <i class="flaticon-graphic-2 "></i>
                                                </span>
                                                <h3 class="card-label">{{ $item->title }} </h3>
                                                @if($item->status == "complete")
                                                    <span >
                                                        <i class="far fa-check-circle text-success" style="font-size: 20px;"></i>
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill
                                                    @if( $item->status == 'running')
                                                        bg-info
                                                    @elseif( $item->status == 'todo')
                                                        bg-warning
                                                    @else
                                                        bg-danger
                                                    @endif
                                                    text-white" style="font-size:10px">{{ $item->status }}
                                                    </span>
                                                @endif

                                            </div>
                                            <div class="card-toolbar">
                                                <div class="pr-2">
                                                    <b>Due Date :</b>  {{Carbon\Carbon::parse($item->due_date)->format('d-m-Y') }}
                                                </div>
                                                <div class="dropdown dropdown-inline">

                                                    <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ki ki-bold-more-hor"></i>
                                                    </a>
                                                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                                        <!--begin::Navigation-->
                                                        <ul class="navi navi-hover ">
                                                            <li class="navi-header font-weight-bold py-4">
                                                                <span class="font-size-lg">Quick Action:</span>
                                                            </li>
                                                            <li class="navi-separator mb-3 opacity-70"></li>
                                                            <li class="navi-item">
                                                                <a href="{{ route('project.show', $item->id) }}" class="navi-link">
                                                                    <span class="navi-text">
                                                                        <span class="label label-xl label-inline label-light-primary">View Project</span>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li class="navi-item" data-id={{ $item->id }}>
                                                                <a href="#" data-id={{ $item->id }} data-toggle="modal" data-target="#delete_modal" class="navi-link delete_btn">
                                                                    <span class="navi-text" data-id={{ $item->id }}>
                                                                        <span class="label label-xl label-inline label-light-danger">Delete Project</span>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <!--end::Navigation-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            {{ $item->description }}
                                        </div>
                                        <div class="card-footer" style="border: none;">
                                            <div class="row">
                                                <div class=" col">
                                                    @foreach($item->ProjectAssigns as $member)
                                                        <span class="tool" data-tip="{{ $member->user->name }} | {{ $member->user->position->title }}">
                                                            <i style="font-size: 25px;" class="far fa-user-circle"></i>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@include("Common.partials.delete_modal")
@endsection

@section("scripts")
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        //delete modal URL
        $(".delete_btn").on("click",(e)=>{
            $("#delete_data_form").attr("action",`./delete-project/`+$(e.target).attr("data-id"))
        });
    });
</script>
@endsection
