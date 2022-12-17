<div class="tab-pane fade" id="demo-1" role="tabpanel" aria-labelledby="contact-tab-1">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Project Files
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8 offset-2">
                    <form method="POST"
                        action="{{ route('project.add_file', $project->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-1">
                            <textarea class="form-control" rows=5 id="exampleTextarea" name="file_description"></textarea>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" name="project_file">
                        </div>
                        <button class="btn btn-primary btn-sm pr-4 pl-4"
                            type="submit">Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{-- <div class="card-footer">
            <table class="table table-striped">
                <thead>
                        <th>
                            #
                        </th>
                        <th>
                        Description
                        </th>
                        <th>
                        File Name
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Uploaded By
                        </th>
                        <td>
                            Action
                        </td>

                </thead>
                <tbody>

                    @foreach ( $project_file as $value )
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td  style='width: 800px' >
                            {!! $value->description !!}
                        </td>
                        <td>
                            <a href="/" download="project{{$project->id}}/{{ $value->file_path }}" download><i class="fa fa-file mr-2 mt-1" aria-hidden="true"></i>Download</a>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($value->created_at)->format('d/m/Y')}}
                        </td>
                        <td>
                            {{ $value->user->name }}
                        </td>
                        <td>
                        <button data-id={{ $value->id }} class="btn edit-btn" style="border:1px solid rgb(219, 219, 219); padding-right: .5rem;" data-toggle="modal" data-target="#editProjectFileModel">
                                <i data-id={{ $value->id }} class="fas fa-edit text-info"></i>
                        </button>
                        <button data-id={{ $value->id }} data-page="hello" data-toggle="modal" data-target="#deleteModal" class="btn delete-btn" style="border:1px solid rgb(219, 219, 219)">
                                <i data-id={{ $value->id }} class="fas fa-trash-alt text-danger"></i>
                        </button>
                        </td>
                    </tr>
                    @endforeach
                </tody>
            </table>

        </div> --}}
    </div>
</div>

