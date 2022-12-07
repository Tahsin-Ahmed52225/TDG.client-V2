<!-- Modal -->
<div class="modal fade" id="role_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="role_submit_edit" method="POST" action=#>
            @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Role Title</label>
                  <input type="text" class="form-control" id="roleName" aria-describedby="emailHelp" name="title_edit">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Slug</label>
                  <input type="text" class="form-control" id="roleSlug" name="slug_edit">
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="saveRole_edit" type="button" class="btn btn-primary">Save Role</button>
        </div>
      </div>
    </div>
</div>



