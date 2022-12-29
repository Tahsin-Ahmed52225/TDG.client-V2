@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'loayouts.employee')
@section("links")
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('dev-assets/css/tooltip.css') }}">
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
              ajax: "{{ route('system.log') }}",
              columns: [
                  {data: 'user_id', name: 'user_id'},
                  {data: 'log_details', name: 'log_details'},
                  {data: 'created_at', name: 'created_at'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ],
            //   "drawCallback": function() {
            //         $(".project-title").on("click",function (e) {
            //             var task_id = $(e.target).attr('data-id');
            //             var URL = "{{ route('project.get_subtask', -1) }}";
            //             URL = URL.replace('-1', task_id);
            //             viewTask(URL);
            //         });
            //         $(".task_checkbox").change(function (e) {
            //             var URL = '{{ route("project.task_complete_toggle") }}'
            //             taskCompleteToggler(e , URL);
            //         });
            //         $(".delete_btn").on("click",(e)=>{
            //             var task_id = $(e.target).attr('data-id');
            //             $('#deleteTaskBtn').off().on("click",()=>{
            //                 var URL = "{{ route('project.delete_subtask', -1) }}";
            //                 URL = URL.replace('-1', task_id);
            //                 taskDelete(URL);
            //             })
            //         })
            //         $(".edit_btn").on("click",(e)=>{
            //             var task_id = $(e.target).attr('data-id');
            //             var URL = "{{ route('project.get_subtask', -1) }}";
            //             URL = URL.replace('-1', task_id);
            //             getTaskData(URL);
            //             $('#editUpdateBtn').off().on("click",()=>{
            //                 var URL = "{{ route('project.update_subtask', -1) }}";
            //                 URL = URL.replace('-1', task_id);
            //                 updateTaskData(URL);
            //             });
            //         })

            //   }
          });

        });
@endsection
