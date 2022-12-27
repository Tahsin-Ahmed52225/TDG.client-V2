@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')


 @section('links')
 <link rel="stylesheet" href="{{ asset('dev-assets/css/single_project.css') }}">
 <link rel="stylesheet" href="{{ asset('dev-assets/css/tooltip.css') }}">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <style>
    .select2{
        width: 100% !important;
    }
 </style>
 @endsection

 @section('content')

 <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>


                                    @if ($errors->has('email'))
                                    @endif
                                    </div>
                                @endforeach
            @endif
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        @if($msg == 'success')
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>

                        @else
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endif
            @endforeach

            <div class="card card-custom gutter-b">
                <div class="card-body">

                    <!--begin::Example-->
                    <div class="example">
                        <div class="example-preview">
                            <ul class="nav nav-pills" id="myTab1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-1" data-toggle="tab" href="#home-1">
                                        <span class="nav-icon">
                                            <i class="flaticon2-layers-1"></i>
                                        </span>
                                        <span class="nav-text">Overview</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="profile-tab-1" data-toggle="tab"
                                        href="#profile-1" aria-controls="profile">
                                        <span class="nav-icon">
                                            <i class="flaticon2-user-1"></i>
                                        </span>
                                        <span class="nav-text">Members</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab-1" data-toggle="tab"
                                        href="#demo-1" aria-controls="contact">
                                        <span class="nav-icon">
                                            <i class="flaticon2-file-1"></i>
                                        </span>
                                        <span class="nav-text">Files</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content mt-5" id="myTabContent1">
                                  @include('project.partials.overview')
                                  @include('project.partials.member')
                                  @include('project.partials.files')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 @endsection


 @section('scripts')
 <script src="{{ asset('dev-assets/js/project/update_project_info.js') }}"></script>
 <script src="{{ asset('dev-assets/js/project/count_down_timer.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

 {{-- Intializing the select2 for project --}}
 <script>
    $('.js-example-basic-multiple').select2({
        allowClear: true,
    });
    $('.add_task').select2({
        allowClear: true,
    });
</script>
{{-- Getting back to the selected tab --}}
 <script>
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab1 a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
{{-- Getting the employee view  --}}
<script>
    $('.project_employee_view').on('click', (e)=>{
        let ID = $(e.target).attr('data-id');
        let URL = "{{route('project.project_assign_by_user')}}"
        $.ajax({
        url: URL,
        type: 'GET',
        data: {
            'id': ID
         },
        success: function (data) {
            $("#employee_name").text(data.name);
            $("#employee_position").text(data.position);
            $("#buttons").html(data.buttons);
        },
        error: function (xhr, exception) {
            var msg = "";
            if (xhr.status === 0) {
                msg = "Not connect.\n Verify Network." + xhr.responseText;
            } else if (xhr.status == 404) {
                msg = "Requested page not found. [404]" + xhr.responseText;
            } else if (xhr.status == 500) {
                msg = "Internal Server Error [500]." +  xhr.responseText;
            } else if (exception === "parsererror") {
                msg = "Requested JSON parse failed.";
            } else if (exception === "timeout") {
                msg = "Time out error." + xhr.responseText;
            } else if (exception === "abort") {
                msg = "Ajax request aborted.";
            } else {
                msg = "Error:" + xhr.status + " " + xhr.responseText;
            }

        }
    });

    })

</script>
{{-- Intializing the datatable  --}}
<script>
    $(document).ready(function() {
        $('#kt_datatable').DataTable();
    });
</script>
{{-- Project file edit and delete modal handling --}}
<script>
    $(window).on('load',function() {
    //Delete project file
    $('.delete-btn').on("click",(e)=>{
       var file_id = $(e.target).attr('data-id');
       var url = `../delete-file/`+file_id;
       console.log(url)
       $('#delete').attr('action', url);
    });
    //Edit project file
    $('.edit-btn').on("click",(e)=>{
        var file_id = $(e.target).attr('data-id');
        $.ajax({
            url: `../get-file/`+file_id,
            type: "GET",
            success: function (data) {
                console.log(data);
                $('#file_description_edit').text(data.description);
                $('#show_file_name').text(data.file_path);
                $('#edit_form').attr('action',`../edit-file/`+file_id)
            },
            error: function (xhr, exception) {
                var msg = "";
                if (xhr.status === 0) {
                    msg = "Not connect.\n Verify Network." + xhr.responseText;
                } else if (xhr.status == 404) {
                    msg = "Requested page not found. [404]" + xhr.responseText;
                } else if (xhr.status == 500) {
                    msg = "Internal Server Error [500]." +  xhr.responseText;
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error." + xhr.responseText;
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else {
                    msg = "Error:" + xhr.status + " " + xhr.responseText;
                }

            }
        });
        $('.save_edit').on('click',()=>{
            $("#edit_form").trigger("submit");
        })
     });
});
</script>
{{-- Adding task into project --}}
<script>
    $("#submitForm").on("click",()=>{
           var title = $('input[name="title"]').val();
           var description = $('textarea[name="description"]').val();
           var priority = $('#priority :selected').val()
           var due_date = $('input[name="due_date"]').val();
           var assigned_member = $('#assignee_member').val();
           $.ajax({
                url: "{{ route('project.create_subtask', $project->id) }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'title':title,
                    'description':description,
                    'priority':priority,
                    'due_date':due_date,
                    'assigned_member':assigned_member,
                    'project_id' : {{ $project->id }}
                },
                success: function (data) {
                    console.log(data.data);
                    if(data.data == "success"){
                        // Closing the modal
                        $('#addSubtaskmodal').modal('toggle');
                        // Reseting the form
                        $('#addsubtask')[0].reset();
                        $('#assignee_member').val('').trigger('change');
                        $('.data-table').DataTable().ajax.reload();
                        toastr.success("Task Added successfully");
                    }else{
                        toastr.warning("Something went wrong");
                    }
                },
                error: function (xhr, exception) {
                    var msg = "";
                    if (xhr.status === 0) {
                        msg = "Not connect.\n Verify Network." + xhr.responseText;
                    } else if (xhr.status == 404) {
                        msg = "Requested page not found. [404]" + xhr.responseText;
                    } else if (xhr.status == 500) {
                        msg = "Internal Server Error [500]." +  xhr.responseText;
                    } else if (exception === "parsererror") {
                        msg = "Requested JSON parse failed.";
                    } else if (exception === "timeout") {
                        msg = "Time out error." + xhr.responseText;
                    } else if (exception === "abort") {
                        msg = "Ajax request aborted.";
                    } else {
                        msg = "Error:" + xhr.status + " " + xhr.responseText;
                    }

                }
            });
       // $("#addsubtask").trigger("submit");
    });
</script>
{{-- Yajra datatbale intialization  --}}
<script type="text/javascript">
    $(function () {

      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('project.show', $project->id) }}",
          columns: [
              {data: 'checkbox', name: 'checkbox',orderable: false, searchable: false},
              {data: 'title', name: 'title'},
              {data: 'taskMember', name: 'taskMember'},
              {data: 'due_date', name: 'due_date'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          "drawCallback": function() {
                $(".project-title").on("click",function (e) {
                    var task_id = $(e.target).attr('data-id');
                    var URL = "{{ route('project.get_subtask', -1) }}";
                    URL = URL.replace('-1', task_id);
                    viewTask(URL);
                });
                $(".task_checkbox").change(function (e) {
                    var URL = '{{ route("project.task_complete_toggle") }}'
                    taskCompleteToggler(e , URL);
                });
                $(".delete_btn").on("click",(e)=>{
                    var task_id = $(e.target).attr('data-id');
                    $('#deleteTask').off().on("click",()=>{
                        var URL = "{{ route('project.delete_subtask', -1) }}";
                        URL = URL.replace('-1', task_id);
                        taskDelete(URL);
                    })
                })
                $(".edit_btn").on("click",(e)=>{
                    var task_id = $(e.target).attr('data-id');
                    var URL = "{{ route('project.get_subtask', -1) }}";
                    URL = URL.replace('-1', task_id);
                    getTaskData(URL);
                    $('#editUpdateBtn').off().on("click",()=>{
                        var URL = "{{ route('project.update_subtask', -1) }}";
                        URL = URL.replace('-1', task_id);
                        updateTaskData(URL);
                    });
                })

          }
      });

    });
    $('#editSubtaskModal').on('hide.bs.modal', function () {
        $(".js-example-basic-multiple").val("");
    })
  </script>
  <script src="{{ asset('dev-assets/js/project/subtask.js') }}"></script>
 @endsection
