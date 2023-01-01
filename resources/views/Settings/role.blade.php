@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')
@section("links")
.btn-sm{
    padding: 0.55rem 0.55rem !important;
}
@endsection

@section("content")

<div class="content d-flex flex-column flex-column-fluid justify-content-center" id="kt_content">
    <!--begin::Entry-->
    <div>
        <!--begin::Container-->
        <div class="container">
            <div class="flash-message"></div>

            <!--begin::Card-->
            <div class="card card-custom gutter-b" id="error_holder">
                @include("Common.partials.flash_message")
                <div class="card-header flex-wrap border-0 pt-6 pb-0">

                    <h3 class="card-title ">
                       User Role
                    </h3>
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#role_add_modal">Add Role</button>
                </div>

                <div class="card-body" style="overflow-X: scroll;">

                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable text-center " id="kt_datatable">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Slug</th>
                                <th>Actions</th>
                            </tr>

                        </thead>
                        <tbody>

                            @foreach ($roles as $values)
                                <tr>
                                    <td>
                                        {{ $values->title }}
                                    </td>
                                    <td>
                                        {{ $values->slug }}
                                    </td>
                                    <td>
                                        @if($values->title == "Manager" || $values->title == "Employee")
                                            <a href="{{ route('settings.permissions', encrypt($values->id)) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Role Permisson"><i class="fas fa-lock"></i></a>
                                        @else
                                            <button  data-id="{{ $values->id }}" data-toggle="modal" data-target="#role_edit_modal" class="btn btn-sm btn-primary edit_role_btn"><i class="fas fa-edit"></i></button>
                                            <button  data-id="{{ $values->id }}" class="btn btn-sm btn-danger delete_btn" data-toggle="modal" data-target="#delete_modal" ><i class="fas fa-trash" aria-hidden="true"></i></button>
                                            <a href="{{ route('settings.permissions', encrypt($values->id)) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Role Permisson"><i class="fas fa-lock"></i></a>
                                        @endif
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
    </div>
</div>


@include('Settings.partials.role_add_modal')
@include('Settings.partials.role_edit_modal')
@include("Common.partials.delete_modal")



@endsection

@section("scripts")
<script>
    $(".edit_role_btn").on("click",(e)=>{
        URL = `./role/`+$(e.target).attr("data-id");
            $.ajax({
            url: URL,
            type: "GET",
            success: function (data) {
                $("input[name='title_edit']").val(data.title);
                $("input[name='slug_edit']").val(data.slug);
                $("#role_submit_edit").attr("action",`./edit-role/`+$(e.target).attr("data-id"))
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
    $(".delete_btn").on("click",(e)=>{
        $("#delete_data_form").attr("action",`./delete-role/`+$(e.target).attr("data-id"))
    });
    $("#roleName").on("keyup",()=>{
        $("#roleSlug").val($('#roleName').val().toLowerCase())
    });
    $("#saveRole").on("click",()=>{
            $("#role_submit").submit();
    });
    $("#saveRole_edit").on("click",()=>{
        $("#role_submit_edit").submit();
    });
</script>
@endsection
