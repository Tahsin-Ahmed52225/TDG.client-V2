@extends((Auth::user()->role->title == "Admin" || Auth::user()->role->title == "Manager") ? 'layouts.'.Auth::user()->role->slug : 'loayouts.employee')
@section("links")

@endsection

@section("content")
<div class="content d-flex flex-column flex-column-fluid justify-content-center" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b" id="error_holder">

            <div class="card-header flex-wrap border-0 pt-6 pb-0">

                <div class="card-title">
                    <h3 class="card-label">{{ $role[0]->title }} : Permissons</h3>
                </div>
            </div>

            <div class="card-body" style="overflow-X: scroll;">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Route Name</th>
                        <th class="text-center" scope="col">Access</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($filteredRoutes as $ele)
                      <tr>
                        <th scope="row">{{ $loop->iteration  }} </th>
                        <td> {{  $ele }} </td>
                        <td class="d-flex justify-content-center"> <input type="checkbox" class="form-check-input " id="exampleCheck1"> </td>
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

@endsection
