@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'layouts.employee')
@section("links")
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("content")
<div class="content d-flex flex-column flex-column-fluid justify-content-center" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b" id="error_holder">

            <div class="card-header flex-wrap border-0 pt-6 pb-0">

                <div class="card-title">
                    <h3 id="role_title" class="card-label" data-id={{ $role[0]->id }}>{{ $role[0]->title }} : Permissons</h3>
                </div>
            </div>

            <div class="card-body" style="overflow-X: scroll;">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Permisson Name</th>
                        <th class="text-center" scope="col">Access</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($permisson as $ele)
                      <tr>
                        <th scope="row">{{ $loop->iteration  }} </th>
                        <td> {{  $ele->name }} </td>
                        <td class="d-flex justify-content-center"> <input  type="checkbox" class="form-check-input permission" value="{{  $ele->id }}" id="exampleCheck1"> </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>


    </div>

</div>

@endsection


@section("scripts")
<script>
    $(".permission").on("change",(el)=>{
       var permisson_id = $(el.target).val();
       var role_id = $('#role_title').attr('data-id');
            $.ajax({
            headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}",
                    },
            url: `{{ route('settings.permission_toggle') }}`,
            type: "POST",
            data: {
                'permisson_id': permisson_id,
                'role_id': role_id,
            },
            success: function (data) {
                console.log(data);
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
                console.log(msg);
            }
        });
    });
</script>

@endsection
