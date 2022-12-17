<div class="tab-pane fade  " id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
    {{-- this is role page starts --}}
    <div class="row">
        <div class="col">
            <div class="card  card-custom  gutter-b">
                <div class="card-body">
                    <form  method="POST" action='{{ route('project.update_member' , $project->id) }}' class="pt-4">
                    @csrf
                        <div class="form-row">
                            <div class="col-2"></div>
                            <div class="form-group col-6">
                                    <select class="js-example-basic-multiple" name="tdg_assignee_member[]" multiple="multiple">
                                        @foreach ( $notAssignUser as $ele )
                                            <option value={{ $ele['id'] }}>{{ $ele['name'] }}</option>
                                        @endforeach
                                    </select>

                            </div>
                            <div class="form-group col-2">
                                <button type="submit" class="btn btn-primary mb-2">Add Member</button>
                            </div>
                            <div class="col-2"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (!$project->manager_id)
        <div class="row">
            <div class="col">
                <div class="card  card-custom  gutter-b">
                    <div class="card-body ">
                        <i class="fas fa-info-circle text-primary"></i>
                        Project Manager Not Assigned. <a href="#"
                            data-toggle="modal"
                            data-target="#addProjectManager">Assign Now?</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        @foreach ($project->ProjectAssigns as $ele)
            <div class="col-md-3">
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0">
                        <div
                            class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                            <div class="row">
                                <div class="col-md-10">
                                    <a href="#"
                                        class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary project_employee_view"
                                        data-id = {{ $ele->id }}
                                        data-toggle="modal"
                                        data-target="#employeeModal">{{ $ele->user->name }}</a>
                                </div>
                                @if ($project->manager_id)
                                    @if ($ele->user->id == $project->manager_id)
                                        <div class="col-md-2">
                                            <span style="cursor: pointer;"
                                                class="badge badge-primary"
                                                title="Project Manager">PM</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="font-weight-bold text-muted font-size-lg">{{ $ele->user->position->title }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        @endforeach
    </div>
    <hr>
    {{-- @if($project->project_type != "inhouse")
        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8 ">
                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                            <div class="row">
                                <div class="col-md-10">
                                    <a href="#"
                                        class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">{{ $client_details['name'] }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span
                                        class="font-weight-bold text-muted font-size-lg">Client</span>
                                </div>
                            </div>
                        </div>
                        <img src="assets/media/svg/avatars/029-boy-11.svg" alt=""
                            class="align-self-end h-100px" />
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
    @endif --}}
    {{-- this is role page ends --}}
</div>


@include('Project.modal.project_assign_model')
@include('Project.modal.project_employee_view')
