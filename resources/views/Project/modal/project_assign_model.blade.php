 <!-- Button trigger modal-->
 <div class="modal fade" id="addProjectManager" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Assign Project Manager</h5>
                <button type="button" class="close"
                    data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table
                    class="table table-sm table-borderless text-center">
                    <tbody class="text-center">
                        @foreach ($project->ProjectAssigns as $item)
                            <tr>
                                <td class="text-left align-middle">
                                    {{ $item->user->name }}</td>
                                <td class="align-middle">
                                    {{$item->user->position->title }}</td>
                                <td>
                                    <form method="GET"
                                        action="{{ route('project.assign_manager' , [$item->user_id, $item->project_id]) }}">
                                        <button class="btn btn-sm btn-primary" type="submit">Assign</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
