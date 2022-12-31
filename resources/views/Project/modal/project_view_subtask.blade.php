<div class="modal fade" id="viewSubtask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="subtask_title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span style="display:block !important;" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <span id="task_project" class="badge badge-dark mb-4">Project : {{ isset($project->title) ?  $project->title : "Global" }}</span>
                <div class="row">
                    <div class="col ">
                        <div class="card card-custom gutter-b card-stretch" style="background-color: #f0f2f7;">
                            <div  class="card-body d-flex justify-content-center align-items-center text-white h4">
                                <button id="task_priority" class="btn btn-sm mr-2">
                                   Status : Hello
                                </button>
                                <button id="task_status" class="btn btn-info btn-sm">
                                   Priority : World
                                </button>
                            </div>
                        </div>
                            {{-- <div class="mb-4">

                                <span id="task_project" class="badge badge-secondary">Project : {{ isset($project->title) ?  $project->title : "Global" }}</span>
                                <span class="badge badge-pill" id="task_priority"></span>
                            </div> --}}
                    </div>
                    <div class="col">
                        <div class="card card-custom gutter-b card-stretch" style="background-color: #1B283F;">
                            <div id="due_date" class="card-body d-flex justify-content-center align-items-center text-white h4">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                  <textarea class="form-control" id="task_details" rows=6 disabled></textarea>
                </div>
                <div class="form-row">

                </div>
        </div>
        <div class="modal-footer" style="justify-content: start">
        </div>
      </div>
    </div>
</div>
