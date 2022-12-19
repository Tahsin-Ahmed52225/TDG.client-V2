<div class="modal fade" id="addSubtaskmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <form id="addsubtask" method="POST" action={{ route('project.create_subtask' , $project->id) }}>
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Subtask</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

                <div class="form-group">
                  <label for="exampleFormControlInput1">Subtask Title</label>
                  <input type="text" class="form-control" id="exampleFormControlInput1" name="title" required>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Subtask Details</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"  name="description" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputCity">Due Date</label>
                      <input type="date" class="form-control" name="due_date" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputState">Priority</label>
                      <select id="inputState" class="form-control" name="priority" required>
                        <option value="high" class="text-danger font-weight-bold">  High</option>
                        <option value="medium"  class="text-warning font-weight-bold">Medium</option>
                        <option value="low" class="text-success font-weight-bold">Low</option>
                      </select>
                    </div>
                    <div class="form-group col">
                        <label for="inputState">Add Member</label>
                        <select class="js-example-basic-multiple" name="assignee_member[]" multiple="multiple" required>
                            @foreach ( $userAssigned as $ele )
                                <option value={{ $ele['id'] }}>{{ $ele['name'] }}</option>
                            @endforeach
                        </select>

                </div>
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitForm" type="button" class="btn btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
</div>
