<div class="modal fade" id="editProjectFileModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-info" id="exampleModalLabel">Edit Project File</h5>
          <a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>
        </div>
        <div class="modal-body">
            <form id='edit_form' method="POST"
                action="#"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-1">
                    <textarea class="form-control" rows=5 id="file_description_edit" name="file_description_edit"></textarea>
                </div>
                <div class="mb-3">
                    <div id="show_file_name" class="mt-2 mb-2">

                    </div>
                    <input class="form-control" type="file" id="formFile" name="project_file_edit">
                </div>
            </form>
        </div>
        <div class="modal-footer">

            <button  type="submit" class="btn btn-primary save_edit">Update</button>

        </div>
      </div>
    </div>
</div>
