@extends('layouts.employee')
@section('links')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('dev-assets/css/tooltip.css') }}">
    <!--end::Page Vendors Styles-->
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card card-custom bgi-no-repeat gutter-b card-stretch">
                            <!--begin::Header-->
                            <div class="card-header border-0 ">
                                <h3 class="card-title font-weight-bolder text-dark">
                                  My  Tasks</h3>
                                <div class="card-toolbar">
                                    <a href="{{ route('project.taskboard') }}"
                                        class="btn btn-light btn-sm font-size-sm font-weight-bolder  text-dark-75">
                                        <i class="fas fa-forward"></i> View Board</a>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body" id="task_board">
                                <table class="table table-striped data-table">
                                    <thead>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                               Task Title
                                            </th>
                                            <th>
                                                Assigned Member
                                             </th>
                                            <th>
                                                Due Date
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("Project.modal.project_view_subtask")
    @include("Project.modal.project_add_subtask")
    @include("Project.modal.project_edit_subtask")
    @include("Project.modal.project_delete_subtask")
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
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
                    url: "{{ route('project.create_subtask', isset($project->id) ? $project->id : 1) }}",
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
                        'project_id' : {{ isset($project->id) ? $project->id : 1 }}
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
              ajax: "{{ route('employee.dashboard') }}",
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
                        $('#deleteTaskBtn').off().on("click",()=>{
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
