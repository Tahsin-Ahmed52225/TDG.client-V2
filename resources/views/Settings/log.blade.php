@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')
@section("links")
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('dev-assets/css/tooltip.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("content")
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
                            <h3 class="card-title font-weight-bolder text-dark">View Log</h3>
                            <div class="card-toolbar">
                                <a href="#" id="delete_all_btn"
                                    class="btn btn-danger btn-sm font-size-sm font-weight-bolder  text-white-75">
                                    <i class="fas fa-trash" style="font-size:13px"></i>Delete All Log
                                </a>
                            </div>
                        </div>

                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body" id="task_board">
                            <table class="table table-striped data-table">
                                <thead>
                                        <th>
                                           Action User
                                        </th>
                                        <th>
                                           Log Description
                                         </th>
                                        <th>
                                           Date
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

@include('Common.partials.delete_model_ajax')
@endsection


@section('scripts')
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    {{-- Yajra datatbale intialization  --}}
    <script type="text/javascript">
        $(function () {
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('settings.log') }}",
              columns: [
                  {data: 'user_id', name: 'user_id'},
                  {data: 'log_details', name: 'log_details'},
                  {data: 'created_at', name: 'created_at'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ],
              "drawCallback": function() {
                $("#delete_all_btn").on("click",(e)=>{
                        $('#modalText').text('Are you sure you want to delete all log records')
                        $('#delete_modal_ajax').modal('toggle');
                        $('#sureDeleteBtn').off().on("click",()=>{
                            URL =  `{{route('settings.log_delete_all')}}`
                            $.ajax({
                                    url: URL,
                                    type: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (data) {
                                        console.log(data);
                                        if(data.msg == 'success'){
                                            $('.data-table').DataTable().ajax.reload();
                                            toastr.success("Log Cleared Successfully");
                                            $('#delete_modal_ajax').modal('toggle');
                                        }else{
                                            toastr.warning("Something went wrong.");
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
                        })
                    })
                    $(".delete_btn").on("click",(e)=>{
                        $('#modalText').text('Are you sure you want to delete this log record?')
                        $('#delete_modal_ajax').modal('toggle');
                        var log_id = $(e.target).attr('data-id');
                        $('#sureDeleteBtn').off().on("click",()=>{
                            URL =  `{{route('settings.log_delete' , '-1')}}`
                            URL = URL.replace('-1', log_id);
                            $.ajax({
                                    url: URL,
                                    type: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (data) {
                                        if(data.msg == 'success'){
                                            $('.data-table').DataTable().ajax.reload();
                                            toastr.success("Log deleted successfully");
                                            $('#delete_modal_ajax').modal('toggle');
                                        }else{
                                            toastr.warning("Something went wrong.");
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
                        })
                    })
              }
          });

        });
    </script>
@endsection
