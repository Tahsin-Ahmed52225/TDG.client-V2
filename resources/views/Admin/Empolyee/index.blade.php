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
                            <h3 class="card-label">View All Member
                        </div>
                    </div>

                    <div class="card-body" style="overflow-X: scroll;">

                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable text-center " id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Stage</th>
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
                                                     <option value={{ $role->slug }}>{{ $role->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="position{{ $values->id }}"
                                                ondblclick="updatePosition({!! $values->id !!})">
                                                {{ $values->role->title }}
                                            </div>


                                        </td>
                                        @if ($values->verified == 1)
                                            <td style="padding: 17px 5px !important;" class="text-success">Verified</td>
                                        @else
                                            <td style="padding: 17px 5px !important;" class="text-warning">Not Verified
                                            </td>
                                        @endif
                                        <td>
                                            <div class="row">
                                                <div class="col d-flex align-items-center justify-content-end   "
                                                    onclick="deleteMember({!! $values->id !!})">
                                                    <i class="fas fa-trash-alt p_icon"></i>
                                                </div>

                                                <div class="col d-flex align-items-center justify-content-start">
                                                    <input class="switchT" data-stage={{ $values->stage }}
                                                        data-user={{ $values->id }} id="toggle{{ $values->id }}"
                                                        type="checkbox" data-on="Lock" data-off="Unlock"
                                                        data-toggle="toggle" data-width="95" data-height="10"
                                                        data-offstyle="danger" <?php if ($values->stage == 1) {
                                                        echo 'checked';
                                                    } ?>>
                                                </div>
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
            $('#kt_datatable').DataTable();
        });
    </script>
@endsection
