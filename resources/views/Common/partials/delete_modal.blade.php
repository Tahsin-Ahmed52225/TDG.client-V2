<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           Are you sure you want to delete data?
        </div>
        <div class="modal-footer">
        <form id="delete_data_form" action="#" method="POST">
        @csrf
          <button id="saveRole" type="submit" class="btn btn-primary">Yes, Sure</button>
        </form>
        </div>
      </div>
    </div>
</div>

@section("partial_scripts")
<script>

</script>
@endsection


