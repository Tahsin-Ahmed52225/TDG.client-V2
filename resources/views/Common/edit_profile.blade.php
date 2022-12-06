@extends("layouts.".Auth::user()->role)
@section("links")
<!--begin::Page Vendors Styles(used by this page)-->
<link href="{{ asset("assets/plugins/custom/fullcalendar/fullcalendar.bundle.css") }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection
@section('content')


<div class="content d-flex flex-column flex-column-fluid justify-content-center" id="kt_content">
    <!--begin::Entry-->
    <div >
        <!--begin::Container-->
        <div class="container" >
            <!--begin::Profile Account Information-->
            @if (session()->has('success'))
                    <div class="alert alert-custom alert-light-success fade show mb-5 d-flex py-2" role="alert">
                        <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
                        <div class="alert-text">{{ session()->get('success') }}
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session()->has('rejected'))
                    <div class="alert alert-custom alert-light-danger fade show mb-5 d-flex py-2" role="alert">
                        <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
                        <div class="alert-text">{{ session()->get('rejected') }}
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session()->has('warning'))
                    <div class="alert alert-custom alert-light-warning fade show mb-5 d-flex py-2" role="alert">
                        <div class="alert-icon"><i class="flaticon-danger"></i></div>
                        <div class="alert-text">{{ session()->get('warning') }}
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                @endif
            <div class="row ">

                <div class="col-md-4 col-sm-12 ">
                    <!--begin::Profile Card-->
                    <div class="card card-custom  my-auto">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::User-->
                            <div>
                            <form method="POST" id="edit_profile" action="{{ route("change_profile_image") }}" enctype='multipart/form-data'>
                            @csrf
                               <div class="image-input image-input-outline" id="kt_image_1" style="background-image: url(assets/media/users/blank.png)">
                                    <div class="image-input-wrapper" style="background-image: url({{ ($user->image == NULL) ? asset("assets/media/users/blank.png") :  asset("files/profile_pics/".$user->image)}})"></div>

                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="profile_avatar_remove"/>
                                    </label>

                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                                <div>
                                    <button id="edit_profile" type="submit" class="ml-1 btn btn-sm btn-primary">Change Profile</button>
                                </div>
                            </form>
                            </div>
                            <div class="pt-2">
                                <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ $user->name }}</a>
                                <div class="text-muted">{{  Str::ucfirst($user->role) }}</div>
                            </div>
                            <!--end::User-->
                            <!--begin::Contact-->
                            <div class="py-9">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold mr-2">Email:</span>
                                    <a href="#" class="text-muted text-hover-primary">{{ $user->email }}</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold mr-2">Phone:</span>
                                    <span class="text-muted">{{ empty($user->number) ? '-' : $user->number }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold mr-2">Joined :</span>
                                    <span class="text-muted"> {{ Carbon\Carbon::parse($user->created_at )->format('M d Y') }} </span>
                                </div>
                            </div>
                            <!--end::Contact-->
                            <!--begin::Nav-->
                            <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                                <div class="navi-item mb-2">
                                    <a href="{{ route('change_password')}}" class="navi-link py-4 active">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="navi-text font-size-lg">Change Password</span>
                                    </a>
                                </div>
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Profile Card-->
                </div>

                <div class="col-md-8 col-sm-12 ">
                    <!--begin::Card-->
                    <div class="card card-custom  my-auto pt-4" id="account_info">
                        <!--begin::Header-->
                        <div class="card-header py-5" >
                            <div class="card-title w-100 justify-content-between">
                                    <div class="float-left">   <h3 class="card-label font-weight-bolder text-dark">Account Information</h3> </div>
                                    <div> <a href="{{ route("my_profile") }}"> <button class="btn btn-sm btn-primary ">View Profile</button> </a> </div>
                            </div>


                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form class="form" method="POST" action="{{ route("edit_profile") }}">
                        @csrf
                            <div class="card-body">
                                <!--begin::Form Group-->
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="">
                                            <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $user->name }}" name="userName" />
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Form Group-->
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-at"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg form-control-solid" value="{{ $user->email }}" disabled />
                                        </div>
                                    </div>
                                </div>
                                  <!--begin::Form Group-->
                                  <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Contact Number</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-phone"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg form-control-solid" value="{{ $user->number }}"  name="userNumber"/>
                                        </div>
                                    </div>
                                 </div>
                                 <!--begin::Form Group-->
                                  <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Position </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <input type="text" class="form-control form-control-lg form-control-solid" value="{{ $user->position }}" disabled  />
                                        </div>
                                    </div>
                                 </div>

                                 <div>
                                    <button type="submit" class="btn btn-primary">Save data</button>
                                </div>
                            </div>

                        </form>
                        <!--end::Form-->
                    </div>
                </div>

            </div>
            <!--end::Profile Account Information-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>


@endsection

@section("scripts")
    <script>
        var avatar1 = new KTImageInput('kt_image_1');
        //console.log(avatar1);
    </script>
   <script src="{{ asset("assets/plugins/custom/fullcalendar/fullcalendar.bundle.js") }}"></script>
   <script src="{{ asset("assets/js/pages/widgets.js") }}"></script>
   <script>
    window.onload = function () {
            $('#update_profile').on('click', function () {
                $("#edit_profile").submit();
            });
        }
   </script>
@endsection



