<div class="tab-pane fade show active" id="home-1" role="tabpanel" aria-labelledby="home-tab-1">

                                {{-- this is overview page --}}
                                <div class="card card-custom p-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="card-icon">
                                                <i class="flaticon-graphic-2 text-primary"></i>
                                            </span>

                                            <div id="tdg_project_name" class="card-label h3"
                                                data-ivalue="{{ $project->id }}">
                                                {{ $project->title }}
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <div class="dropdown dropdown-inline">
                                                <a href="#"
                                                    class="btn btn-hover-light-primary btn-sm btn-icon"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ki ki-bold-more-hor"></i>
                                                </a>
                                                <div
                                                    class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                                    <!--begin::Navigation-->
                                                    <ul class="navi navi-hover">
                                                        <li class="navi-header font-weight-bold py-4">
                                                            <span class="font-size-lg">Quick Action</span>
                                                            <i class="flaticon2-information icon-md text-muted"
                                                                data-toggle="tooltip" data-placement="right"
                                                                title="Project Quick Actions"></i>
                                                        </li>
                                                        <li class="navi-separator mb-3 opacity-70"></li>
                                                        <li class="navi-item">
                                                            <a  id="project_settings" href="#" class="navi-link"  data-toggle="modal" data-id={{ $project->id }} data-target="#projectSettingsModal">
                                                                <span class="navi-text">
                                                                    <span
                                                                        class="label label-xl label-inline label-light-info">
                                                                        Project Settings</span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="navi-item">
                                                            <a href="#" data-id={{ $project->id }} data-toggle="modal" data-target="#delete_modal" class="navi-link delete_btn" >
                                                                <span class="navi-text" data-id={{ $project->id }}>
                                                                    <span class="label label-xl label-inline label-light-danger" data-id={{ $project->id }}>
                                                                        Delete Project
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!--end::Navigation-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tdg_project_description" class="card-body mb-2"
                                        data-ivalue="{{ $project->id }}">
                                        {{ $project->description }}
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <!--begin::Tiles Widget 7-->
                                            <div id="timer_section"
                                                data-date={{ \Carbon\Carbon::parse($project->due_date)->format('m/d/Y') }}
                                                class="card card-custom gutter-b card-stretch "
                                                style="background-color: #1B283F;">
                                                <!--begin::Body-->
                                                <div
                                                    class="card-body d-flex justify-content-center align-items-center">
                                                    <div id="heading">
                                                        <h1>Time Out</h1>
                                                    </div>
                                                    <div id="countdown">
                                                        <ul style="padding-left:0px;">
                                                            <li class="countdown_section">days<span
                                                                    id="days"></span></li>
                                                            <li class="countdown_section">Hours<span
                                                                    id="hours"></span></li>
                                                            <li class="countdown_section">Minutes<span
                                                                    id="minutes"></span></li>
                                                            <li class="countdown_section">Seconds<span
                                                                    id="seconds"></span></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Tiles Widget 7-->
                                        </div>
                                        <div class="col-xl-6">
                                            <!--begin::Tiles Widget 7-->
                                            <div class="card card-custom bgi-no-repeat gutter-b card-stretch"
                                                style="background-color: #ffffff; background-position: 0 calc(100% + 0.5rem); background-size: 100% auto;">
                                                <!--begin::Body-->
                                                <div class="card-body">
                                                        <table class="table">
                                                        <thead class="thead-light">
                                                            <tr class="text-center">
                                                            <th scope="col">Project Status</th>
                                                            <th scope="col">Project Priority</th>
                                                            <th scope="col">Project Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="text-center">
                                                            <th scope="row"><a href='#' class="btn @if($project->status == 'running') btn-info @elseif($project->status == 'todo') btn-light @elseif($project->status == 'complete') btn-success @else btn-danger @endif font-weight-bold ">{{ Str::upper($project->status)}}</a></th>
                                                            <td><a href='#' class="btn @if($project->priority == 'high') btn-danger @elseif($project->priority == 'medium') btn-warning @else btn-success @endif font-weight-bold "> {{ Str::upper($project->priority)}} </a></td>
                                                            <td><a href='#' class="btn btn-light font-weight-bold "> {{ Str::upper($project->type)}}</a></td>
                                                            </tr>
                                                        </tbody>
                                                        </table>
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Tiles Widget 7-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card mb-6">
                                                <div class="card-body">
                                                    <h3 class="card-title font-weight-bolder text-dark">Project Progress : </h3>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated {{ ($completedTask === count($tasks)) ? "bg-success":"" }} " role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{ (count($tasks) >0 ) ? ($completedTask/count($tasks))*100 : 0}}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--begin::List Widget 4-->
                                            <div class="card card-custom card-stretch gutter-b">
                                                <!--begin::Header-->
                                                <div class="card-header border-0">
                                                    <h3 class="card-title font-weight-bolder text-dark">
                                                        Tasks</h3>
                                                    <div class="card-toolbar" data-toggle="modal" data-target="#addSubtaskmodal">
                                                        <a href="#"
                                                            class="btn btn-light btn-sm font-size-sm font-weight-bolder  text-dark-75">
                                                            <i class="fas fa-plus"></i> Create</a>
                                                    </div>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body" id="task_board">
                                                    <table class="table table-striped data-table">
                                                        <thead>
                                                                <th>
                                                                    #
                                                                </th>
                                                                <th>
                                                                   Task Title
                                                                </th>
                                                                <th>
                                                                    Assigned Member
                                                                 </th>
                                                                <th>
                                                                    Due Date
                                                                </th>
                                                                <th>
                                                                    Action
                                                                </th>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--end::Body-->

                                            </div>
                                            <!--end:List Widget 4-->
                                        </div>

                                    </div>
                                </div>
</div>
@include("Project.partials.settings")
@include("Project.modal.project_view_subtask")
@include("Project.modal.project_add_subtask")
@include("Project.modal.project_edit_subtask")
@include("Project.modal.project_delete_subtask")
{{-- @include("admin.project.modal.subtask_modal") --}}

