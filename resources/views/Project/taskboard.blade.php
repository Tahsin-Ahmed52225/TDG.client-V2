@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')
@section('links')
<link rel="stylesheet" href="{{ asset('dev-assets/css/tooltip.css') }}">
<link href="{{ asset('assets/plugins/custom/kanban/kanban.bundle.css')  }}" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Task Board</h3>
                    </div>
                    @if(Auth::user()->role->title != "Admin")
                        <div class="card-toolbar">
                            <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-sm font-size-sm font-weight-bolder  text-dark-75">
                                <i class="fas fa-backward"></i> All Task
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div id="kt_kanban_2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("Project.modal.project_view_subtask")
@endsection

@section('scripts')

<script src="{{ asset('assets/plugins/custom/kanban/kanban.bundle.js') }}"></script>
<script>
     var URL = `{{ route('project.taskboard') }}`
     var STATUS_URL = `{{ route('project.change_task_stage') }}`
     var TASK_URL = "{{ route('project.get_subtask', -1) }}";
</script>
<script src="{{ asset('assets/js/pages/features/miscellaneous/kanban-board.js') }}"></script>


@endsection
