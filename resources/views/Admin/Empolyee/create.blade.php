@extends('layouts.admin')



@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            @if ($errors->has('email'))
                            @endif
                        </div>
                    @endforeach
                @endif

                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        @if ($msg == 'success')
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a
                                    style="color:white;" href="{{ route('view_member') }}"> <u>View Member</u> </a>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>
                        @else
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#"
                                    class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                        @endif
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card card-custom">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title ">
                                    Create Member Account
                                </h3>
                                <a href="{{ route('view_member') }}"> <button class="btn btn-sm btn-info">View All
                                        Member</button>
                                </a>
                            </div>
                            <!--begin::Form-->
                            <form method="POST" action={{ route('add_member') }}>
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter name"
                                                name="tdg_name" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter phone"
                                                name="tdg_phone" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Email address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" placeholder="Enter email"
                                                name="tdg_email" />
                                        </div>

                                    </div>
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="exampleSelect1">Select position <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="exampleSelect1" name="tdg_position">
                                                @foreach ( $positions as $ele )
                                                    <option value={{ $ele->id }}> {{$ele->title}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleSelect1">Select designation <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="exampleSelect1" name="tdg_role">
                                                @foreach ( $roles as $ele )
                                                    <option value={{ $ele->id }}> {{$ele->title}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="exampleInputPassword1"
                                            placeholder="Password" name="tdg_password" />
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-lg btn-primary">Add Member</button>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








@endsection
