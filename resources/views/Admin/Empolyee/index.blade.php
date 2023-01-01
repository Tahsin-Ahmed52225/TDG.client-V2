@extends('layouts.admin')

@section('links')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('dev-assets/css/datatable.css') }}">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dev-assets/css/style.css') }}">
    <!--end::Page Vendors Styles-->
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid " id="kt_content" style="padding-top: 0px;">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->

            <div class="container">
                <div class="flash-message"></div>

                <!--begin::Card-->
                <div class="card card-custom gutter-b" id="error_holder">

                    <div class="card-header flex-wrap border-0 pt-6 pb-0">

                        <div class="card-title">
                            <h3 class="card-label">View {{ $title }} Member
                        </div>
                    </div>

                    <div class="card-body" style="overflow-X: scroll;">

                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable text-center " id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($users as $values)
                                    <tr id="row{{ $values->id }}">

                                        <td style="padding: 17px 5px !important;">{{$loop->iteration}} </td>
                                        <td id="name{{ $values->id }}" style="padding: 17px 5px !important;"
                                            ondblclick="updateName({!! $values->id !!})">{{ $values->name }}</td>
                                        <td id="email{{ $values->id }}" style="padding: 17px 5px !important;"
                                            ondblclick="updateEmail({!! $values->id !!})">{{ $values->email }}</td>
                                        <td id="number{{ $values->id }}" style="padding: 17px 5px !important;"
                                            ondblclick="updatePhone({!! $values->id !!})">{{ $values->phone }}</td>
                                        <td style="padding: 17px 5px !important;">

                                            <div style="display:none;" id="position-edit{{ $values->id }}">
                                                <select style="border:none" id="positionD{{ $values->id }}">
                                                    @foreach($roles as $role)
                                                     <option value={{ $role->id }}>{{ $role->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="position{{ $values->id }}"
                                                ondblclick="updatePosition({!! $values->id !!})">
                                                {{ $values->role->title }}
                                            </div>


                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <i class="fas fa-sign-in-alt pr-3 login_icon" data-id={{ $values->id }} data-toggle="tooltip" data-placement="top" title="Login Into Member Dashboard"></i>
                                                <div class=" pr-3" data-id={{ $values->id }}  data-toggle="modal" data-target="#employeeDelete" >
                                                    <i class="fas fa-trash-alt p_icon" data-id={{ $values->id }} data-toggle="tooltip" data-placement="top" title="Delete Member"></i>
                                                </div>
                                                <input class="switchT" data-stage={{ $values->stage }}
                                                data-user={{ $values->id }} id="toggle{{ $values->id }}"
                                                type="checkbox" data-on="Lock" data-off="Unlock"
                                                data-toggle="toggle" data-width="95" data-height="10"
                                                data-offstyle="danger" <?php if ($values->stage == 1) {
                                                echo 'checked';
                                            } ?>>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>


@include('Admin.Modals.employee_delete')


@endsection



@section('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!--begin::Page Vendors(used by this page)-->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <!--end::Page Scripts-->
    <script src="{{ asset('dev-assets/js/script.js') }}"></script>

    <script>
        $(document).on('click', '.toggle', function() {
            let id = $(this).children(".switchT").attr("data-user");
            let stage = $(this).children(".switchT").attr("checked");
            switchT(id, stage);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#kt_datatable').DataTable({
                "paging": false
            });
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        $('.p_icon').on("click", (e)=>{
               var employee_id = $(e.target).attr("data-id");
               $("#employee_del_button").attr('onclick',`deleteMember(`+employee_id+`)`);
        });
        $('.login_icon').on("click", (e)=>{
               var employee_id = $(e.target).attr("data-id");
               $.ajax({
                    headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                        },
                    url: `{{ route('admin.employee_login') }}`,
                    type: "POST",
                    data: { user_id: employee_id },
                    success: function (data) {
                        console.log(data);
                        toastr.success("Logged in successfully",{
                            timeOut: 2000,
                            preventDuplicates: true,
                        });
                        setTimeout(function () {
                            window.location.href = data.url;
                            window.clearTimeout(tID);		// clear time out.
                        }, 3000);

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
        });

    </script>
@endsection
