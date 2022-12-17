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
                                                            <a href="#" class="navi-link">
                                                                <span class="navi-text">
                                                                    <span
                                                                        class="label label-xl label-inline label-light-danger">Delete Project</span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!--end::Navigation-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tdg_project_description" class="card-body"
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
                                            <!--begin::List Widget 4-->
                                            <div class="card card-custom card-stretch gutter-b">
                                                <!--begin::Header-->
                                                <div class="card-header border-0">
                                                    <h3 class="card-title font-weight-bolder text-dark">
                                                        Tasks</h3>
                                                    <div class="card-toolbar" id="create_task">
                                                        <a href="#"
                                                            class="btn btn-light btn-sm font-size-sm font-weight-bolder  text-dark-75">
                                                            <i class="fas fa-plus"></i> Create</a>
                                                    </div>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body" id="task_board">
                                                    {{-- @if ($tasks) --}}
                                                        @php
                                                            $i = 0;
                                                        @endphp
                                                        {{-- @foreach ($tasks as $items) --}}
                                                            {{-- <div class="d-flex align-items-center mt-3"
                                                                id="task{{ $items->id }}">
                                                                <!--begin::Bullet-->
                                                                <span
                                                                    class="bullet bullet-bar bg-success align-self-stretch"></span>
                                                                <!--end::Bullet-->
                                                                <!--begin::Checkbox-->
                                                                <label
                                                                    class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
                                                                    <input type="checkbox" name="select"
                                                                        data-id={{ $items->id }}
                                                                        class="task_checkbox"
                                                                        {{ $items->complete == 1 ? 'checked' : '' }}>
                                                                    <span></span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                                <!--begin::Text-->
                                                                <div class="d-flex flex-column flex-grow-1"
                                                                    data-toggle="modal"
                                                                    data-target="#subtask_details"
                                                                    style="cursor: pointer;"
                                                                    onclick="getSubTaskDetails({{ $items->id }})">
                                                                    <div class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1 sub_task_title"
                                                                        id="taskname{{ $items->id }}"
                                                                        data-id={{ $items->id }}
                                                                        style="margin-top:4px; height:20px;
                                                                                                @if ($items->complete == 1) text-decoration: line-through; @endif">
                                                                        {{ $items->Name }}
                                                                    </div>
                                                                </div>
                                                                <!--end::Text-->
                                                                <!--begin::Dropdown-->
                                                                <div class="dropdown dropdown-inline ml-2">
                                                                    <a href="#"
                                                                        class="btn btn-hover-light-primary btn-sm btn-icon"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        <i class="ki ki-bold-more-hor"></i>
                                                                    </a>
                                                                    <div
                                                                        class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                                                        <!--begin::Navigation-->
                                                                        <ul class="navi navi-hover">
                                                                            <li
                                                                                class="navi-item bg-light-danger rounded">
                                                                                <a class="sub_task_delete navi-link"
                                                                                    data-id={{ $items->id }}>
                                                                                    <span
                                                                                        class="navi-text">
                                                                                        Delete Task
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                        <!--end::Navigation-->
                                                                    </div>
                                                                </div>

                                                            </div> --}}
                                                            {{-- sub task details starts --}}
                                                            <!-- Button trigger modal -->
                                                            <!-- Modal -->

                                                            {{-- sub task details ends --}}
                                                            @php
                                                                $i++;
                                                            @endphp
                                                        {{-- @endforeach --}}
                                                    {{-- @endif --}}
                                                </div>
                                                <!--end::Body-->

                                            </div>
                                            <!--end:List Widget 4-->
                                        </div>

                                    </div>
                                </div>
</div>
@include("Project.partials.settings")
{{-- @include("admin.project.modal.subtask_modal") --}}

