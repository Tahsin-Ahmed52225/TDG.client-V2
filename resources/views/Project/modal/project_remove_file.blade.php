<div class="modal fade" id="deleteProjectFile" tabindex="-1" aria-labelledby="deleteProjectFile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete File</h1>
        </div>
        <div class="modal-body">
          Delete file from this project
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <form id="delete" method="POST" action="#">
           @csrf
            <button  type="submit" class="btn btn-danger ">Yes! Sure</button>
          </form>
        </div>
      </div>
    </div>
</div>
