@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')

@section('links')


@endsection


@section('content')


@endsection



@section('scripts')

@endsection
