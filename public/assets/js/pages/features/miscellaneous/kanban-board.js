function changeTaskStatus(taskId, status,dataValues) {
    $.ajax({
        url: STATUS_URL,
        type: "POST",
        headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            taskId: taskId,
            status: status,
            dataValues: dataValues
        },
        success: function (data) {
            if(data.status == 'success'){
                toastr.success("Task Status updated successfully");
            }else{
                toastr.error("Task Status update failed");
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
                    $("#subtask_title").css('text-decoration', (data.data.complete == 0)? 'none' : 'line-through');
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
                    var members = 'Members :'
                        data.assigned_member.forEach(function(value) {
                             members =  members+`<span class="tool" data-tip="`+value+`">
                                                   <i style="font-size: 25px;" class="far fa-user-circle"></i>
                                                </span>`
                        });
                    $('.modal-footer').html(members);
                }else{
                    toastr.error(data.msg);
                }
            }
        });
}
$.ajax({
        url: URL,
        type: "GET",
        success: function (data) {
            var KTKanbanBoardDemo = function() {

                var _demo2 = function() {
                    var kanban = new jKanban({
                        element: '#kt_kanban_2',
                        gutter: '0',
                        widthBoard: '295px',
                        boards: [{
                                'id': 'todo',
                                'title': 'Todo',
                                'class': 'info',
                                'item': data.todo,
                            },
                            {
                                'id': 'hold',
                                'title': 'Hold',
                                'class': 'warning',
                                'item': data.hold
                            }, {
                                'id': 'working',
                                'title': 'Working',
                                'class': 'primary',
                                'item': data.working
                            }, {
                                'id': 'complete',
                                'title': 'Complete',
                                'class': 'success',
                                'item': data.complete
                            }
                        ],
                        dropEl           : function (el, target, source, sibling) {
                            var dataValues = $(target).children().siblings().children().map(function(){
                                return  $(this).attr('data-id')
                            }).get();
                            if(dataValues.length == 0){
                                dataValues[0] = $(el).children().attr('data-id');
                            }
                            console.log(dataValues);
                            changeTaskStatus($(el).children().attr('data-id'),$(target).parent().attr('data-id') , dataValues)
                        },
                        click            : function (el) {
                            viewTask(`../project/get-subtask/`+$(el).children().attr('data-id'));
                        },
                    });
                }
                return {
                    init: function() {
                        _demo2();
                    }
                };
            }();

            $(document).ready(function() {
                KTKanbanBoardDemo.init();
            });

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


// Class definition



