<div class="modal fade" id="projectSettingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-info" id="exampleModalLabel">Project Settings</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>
        </div>
        <div class="modal-body">
            <form id="project_settings_form" action="{{ route('project.edit' , $project->id) }}" method="POST">
            @csrf
                <input type="hidden" name="project_id" value={{ $project->id }}>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Project Due Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tdg_project_date"  value="{{ Carbon\Carbon::parse($project->due_date)->format('Y-m-d') }}" required/>
                    </div>
                 </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="exampleSelect1">Project Status</label>
                        <select class="form-control"  name="tdg_project_status">
                            <option value="todo" @if($project->status == "todo") selected @endif class="text-dark font-weight-bold">Todo</option>
                            <option value="running" @if($project->status == "running") selected @endif class="text-info font-weight-bold">Running</option>
                            <option value="complete" @if($project->status == "complete") selected @endif class="text-success font-weight-bold">Complete</option>
                            <option value="stopped" @if($project->status == "stopped") selected @endif class="text-danger font-weight-bold">Stopped</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleSelect1">Project Priority</label>
                        <select class="form-control"  name="tdg_project_priority" >
                            <option value="high" class="text-danger font-weight-bold" @if($project->priority == "high") selected @endif>  High</option>
                            <option value="medium"  class="text-warning font-weight-bold" @if($project->priority == "medium") selected @endif>Medium</option>
                            <option value="low" class="text-success font-weight-bold" @if($project->priority == "low") selected @endif>Low</option>
                        </select>
                    </div>
                 </div>

                 <div class="form-group ">
                    <label for="exampleSelect1">Project Type</label>
                    <select id="project_type" class="form-control"  name="tdg_project_type" >
                        <option value="rnd" class="text-danger font-weight-bold" @if($project->type == "rnd") selected @endif>R&D</option>
                        <option value="inhouse"  class="text-warning font-weight-bold" @if($project->type == "inhouse") selected @endif>In House</option>
                    </select>
                </div>
              </form>
        </div>
        <div class="modal-footer">
            <button  id="save_settings" class="btn btn-primary save_edit">Save</button>
        </div>
      </div>
    </div>
</div>



