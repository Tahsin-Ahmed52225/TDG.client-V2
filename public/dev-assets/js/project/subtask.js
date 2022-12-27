    // Toggle task complete value
    function taskCompleteToggler(e , URL) {
        $.ajax({
            type: 'GET',
            url: URL,
            data: {
                task_id: $(e.target).attr('data-id'),
            },
            success: function (data) {
                console.log(data);
                if(data.data === 0 || data.data === 1){
                    $(e.target).parent().siblings().children('.project-title').css('text-decoration', data.data == 1 ? 'line-through' : 'none');
                    if ($(".progress-bar")[0]){
                        var progress_width = data.project_progress.toString()+`%`
                        $('.progress-bar').width(progress_width)
                        if(progress_width == '100%'){
                            $('.progress-bar').addClass('bg-success')
                        }else{
                            $('.progress-bar').removeClass('bg-success')
                        }
                    }
                    toastr.success((data.data == 1)? "Task Complete": "Task mark imcomplete");

                }else if(data.data == "not found"){
                    toastr.success("Task not found");
                }else{
                    toastr.success("Method not allowed");
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });

    }
    // Delete task delete
    function taskDelete(URL){
        $.ajax({
            type: 'GET',
            url: URL,
                success: function (data) {
                    if(data.data = "success"){
                        $('.data-table').DataTable().ajax.reload();
                        toastr.success("Task Deleted Successfully");
                        $('#deleteTask').modal('hide');

                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });
    }
    // Get task details
    function getTaskData(URL){
        $.ajax({
            type: 'GET',
            url: URL,
                success: function (data) {
                    if(data.msg = "success"){
                        console.log(data);
                        var date = data.data.due_date.slice(0, 10);
                        $('input[name="edit_title"]').val(data.data.title);
                        $('textarea[name="edit_description"]').val(data.data.description);
                        $('input[name="edit_due_date"]').val(date);
                        $('select[name="edit_priority"]').val(data.data.priority);
                        $(".js-example-basic-multiple").val(data.assigned_member);
                        $('.js-example-basic-multiple').trigger('change');
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
    }
    // Update task details
    function updateTaskData(URL){
           var title = $('input[name="edit_title"]').val();
           var description = $('textarea[name="edit_description"]').val();
           var priority = $('select[name="edit_priority"]').val();
           var due_date = $('input[name="edit_due_date"]').val();
           var assigned_member = $('.js-example-basic-multiple').val();
           $.ajax({
            url: URL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'title':title,
                'description':description,
                'priority':priority,
                'due_date':due_date,
                'assigned_member':assigned_member,
            },
            success: function (data) {
                console.log(data);
                if(data.data == "success"){
                    // Closing the modal
                    $('#editSubtaskModal').modal('toggle');
                    // Reseting the form
                    $('#editSubtask')[0].reset();
                    $('#assignee_member').val('').trigger('change');
                    $('.data-table').DataTable().ajax.reload();
                    toastr.success("Task Edited successfully");
                }else{
                    toastr.warning("Something went wrong");
                }
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

            }
        });
    }
    function viewTask(URL){
        $.ajax({
            type: 'GET',
            url: URL,
                success: function (data) {
                    if(data.msg = "success"){
                        console.log(data);
                        $("#subtask_title").text(data.data.title);
                        $("#task_details").text(data.data.description);
                        if(data.data.priority == 'low'){
                            $("#task_priority").removeClass('badge-warning');
                            $("#task_priority").removeClass('badge-danger');
                            $("#task_priority").addClass('badge-primary');
                        }else if(data.data.priority == 'high'){
                            $("#task_priority").removeClass('badge-warning');
                            $("#task_priority").removeClass('badge-primary');
                            $("#task_priority").addClass('badge-danger');

                        }else{
                            $("#task_priority").removeClass('badge-primary');
                            $("#task_priority").removeClass('badge-danger');
                            $("#task_priority").addClass('badge-warning');
                        }
                        $("#task_priority").text(`Priority: `+ data.data.priority);
                        $("#due_date").text(`Due Date: `+ data.data.due_date.slice(0, 10));
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
    }





