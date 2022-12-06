@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'loayouts.employee')
@section("links")

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
                                        @if($values->title == "Admin" || $values->title == "Manager" || $values->title == "Employee")
                                            <span>Default</span>
                                        @else
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
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
@include('Settings.partials.role_delete_modal')



@endsection

@section("script")

@endsection
