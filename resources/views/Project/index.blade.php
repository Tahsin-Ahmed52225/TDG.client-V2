@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')

@section('links')
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset("dev-assets/css/tooltip.css") }}">
@endsection


@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-body">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                @if($msg == 'success')
                                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>

                                @else
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
                            @endif
                    @endforeach
                    <!--begin: Datatable-->
                   <table  class="table table-bordered table-hover table-checkable text-left "  id="myTable" >
                        <thead>
                             <tr >

                                <th style="width:50%; ">Project Name</th>
                                <th>Assign Member</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>

                        </thead>
                        <tbody id="table_body">
                            @foreach ($projects as $values )

                                            <tr onclick="window.location='#';">
                                                <td style="padding: 17px 10px !important; width:50%;">
                                                    {{ $values->title }}
                                                </td>
                                                <td id="email{{ $values->id }}" style="padding: 17px 10px !important;">

                                                    @foreach($values->ProjectAssigns as $member)
                                                        <span class="tool" data-tip="{{ $member->user->name }} | {{ $member->user->position->title }}">
                                                            <i style="font-size: 25px;" class="far fa-user-circle"></i>
                                                        </span>
                                                    @endforeach

                                                </td>
                                                <td>
                                                    {{Carbon\Carbon::parse($values->due_date)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    <span class="badge
                                                        @if($values->priority =="low")
                                                        badge-success
                                                        @elseif($values->priority =="medium")
                                                        badge-warning
                                                        @else
                                                        badge-danger
                                                        @endif
                                                        "> {{ $values->priority }}
                                                    </span>

                                                </td>
                                                <td>
                                                    <span class="badge
                                                        @if($values->status =="complete")
                                                        badge-success
                                                        @elseif($values->status =="running")
                                                        badge-info
                                                        @elseif($values->status =="todo")
                                                        badge-warning
                                                        @else
                                                        badge-danger
                                                        @endif">
                                                        {{ $values->status }}
                                                    </span>

                                                </td>
                                                <td>
                                                    <a href="{{ route('project.show', $values->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button data-id={{ $values->id }} class="btn btn-sm btn-danger delete_btn" data-toggle="modal" data-target="#delete_modal">
                                                        <i data-id={{ $values->id }} class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>

        </div>
    </div>
</div>
@include("Common.partials.delete_modal")
@endsection



@section('scripts')
 <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
 <script>
    $(document).ready( function () {
        $('#myTable').DataTable();
        $(".delete_btn").on("click",(e)=>{
            $("#delete_data_form").attr("action",`./delete-project/`+$(e.target).attr("data-id"))
        });
    });
 </script>
@endsection
