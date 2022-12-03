    var id = $("#tdg_project_name").data("ivalue");
    var alltask = [];
    //Adding new subtask on create button click

    //Updating subtask status on checkbox click
    $("#task_board").on('change', '.task_checkbox', function (e) {
        // console.log($(e.target).data("id"));
        changeStage($(e.target).data("id"));
    });
    //Updating subtask on double click
    $("#task_board").on('dblclick', '.modal-title', function (e) {
        updateTask(e, $(this).data("id"));
    });
    $("#task_board").on('dblclick', '.sub_task_title', function (e) {
        if ($(e.target).text() === "") {

            updateTask(e, $(this).data("id"));
        }
    });
    //Deleteing subtask on delete button click
    $("#task_board").on('click', '.sub_task_delete', function (e) {

        deleteSubtask($(this).data("id"));
    });
    //Updating subtask description on enter key press
    $("#task_board").on("dblclick", ".sub_task_description", function () {
        $(this).prop("contenteditable", true);
        $(this).focus();
        $(this).on("keypress", function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                if ($(this).text() === "") {
                    // $(this).text("P");
                } else {
                    $(this).prop("contenteditable", false);
                    $(this).html(function () {
                        $(this).html = $(this).html().replace(/(?:&nbsp;|<br>)/, '');
                    });
                    updateSubTaskDescription($(this).data("ivalue"), $(this).text());
                }


            }
        });
    });
    $("#subtask_title").on("dblclick",(e)=>{
        updateTaskTitle(e)
    })
    $("#subtask_description").on("dblclick",(e)=>{
        updateTaskDescription(e)
    })
    $("#create_task").on("click",function (event) {
        event.preventDefault();
        $.ajax({
            type: 'GET',
            url: '../get_new_task_id',
            data: {
                project_id: id,
            },
            success: function (data) {
                console.log(data);
                addTask(data);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    });
    function changeStage(id) {
        $.ajax({
            type: 'GET',
            url: '../update_subtask_status',
            data: {
                subtask_id: id,
            },
            success: function (data) {
                $('.toast').toast("show");
                $('.toast-body').text("Project Subtask Status Changed");
                $('#taskname' + id).css('text-decoration', data == 1 ? 'line-through' : 'none');
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });

    }
    //Delete Subtask
    function deleteSubtask(id) {
        $.ajax({
            type: 'GET',
            url: '../delete-project-task',
            data: {
                subtask_id: id,
            },
            success: function (data) {
                if (data.success) {
                    $('#task' + id).fadeOut("normal", function () {
                        $(this).remove();
                    });
                    $('.toast').toast("show");
                    $('.toast-body').text("Project Subtask Deleted Successfully");
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });

    }
    function updateTask(event, i) {

        // console.log(event.target);
        $(event.target).attr('contenteditable', 'true');
        $(event.target).keyup(function () {
            if (window.event.keyCode === 13) {
                event.preventDefault();
                newSaveTask($(event.target).text(),id,i);
                $(event.target).attr('contenteditable', 'false');
            } else {
                if (alltask.length == 0) {
                    console.log(i);
                    var new_task = { id: i, task: $(event.target).text(), stage: false };
                    alltask[0] = new_task;
                } else {
                    alltask[0].task = $(event.target).text();
                }

            }
        });
    };
    function subtaskMember(name,user_id,subtask_id){
        URL = `../remove-member-subtask/`+subtask_id+`/`+user_id
        $("#removeMemberlabel").text(name);
        $("#removeMember").attr('action',URL);
    };
    function getSubTaskDetails(subtask_id)
    {
        url = '../get-subtask-details/';
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                subtask_id: subtask_id,
            },
            success: function (data) {
                URL = `../assign-subtask/`+data.subtask.id;
                console.log(data.subtask.complete)
                $("#subtask_title").text(data.subtask.Name);
                $("#subtask_title").css("text-decoration",(data.subtask.complete == 1) ? "line-through" : "none")
                $("#subtask_title").attr("data-id",data.subtask.id);
                $("#subtask_description").attr("data-id",data.subtask.id);
                $("#assign_subtask_member").attr("action",URL);
                if(data.subtask.Description != null){
                    $("#subtask_description").text(data.subtask.Description)
                }else{
                    $("#subtask_description").text("@Double Tap To Add Description")
                    $("#subtask_description").css("color",'gray')
                }
                data.user.forEach((item, index)=>{
                    $user = `<span class="tool text-center" data-tip="`+item.name+`">`+
                                `<i data-toggle="modal" onclick="subtaskMember('`+item.name+`',`+item.id+`,`+data.subtask.id+`)" data-target="#removeMemberSubtask" style="font-size: 40px;" class="far fa-user-circle mr-1"></i>`+
                            `</span>`;
                    $(".subtask_member").append($user);
                })
            }
        });

    }
    //Update Subtask title
    function updateTaskTitle(event) {
        id = $("#subtask_title").attr("data-id");
        $(event.target).attr('contenteditable', 'true');
        $(event.target).keydown(function () {
            if (window.event.keyCode === 13 || window.event.which === 13) {
                event.preventDefault();
                event.stopPropagation();
                $(event.target).attr('contenteditable', 'false');
                saveTask($(event.target).text(), id);
                $("#taskname" + id).text($(event.target).text());
                if ($(`#task_wrapper` + id).data("target") === "#") {
                    // alert("Please add description");
                    $(this).css('cursor', 'pointer');
                    $(`#task_wrapper` + id).attr('data-target', `#exampleModal` + id);
                    $(`#exampleModalLabel` + id).text($(event.target).text());

                }
            } else {
                if ($(event.target).text().length >= 40) {
                    // alert("Subtask title should be less than 42 characters");
                    // $(event.target).attr('contenteditable', 'false');
                }
                //console.log();
            }
        });
    };
    function newSaveTask(text,projectID, subtaskID) {
        console.log("Subtask ID",subtaskID);
        console.log("Project ID",projectID);
        $.ajax({
            type: 'GET',
            url: '../update-subtask-title',
            data: {
                subtask_id: subtaskID,
                subtask_title: text,
                project_id : projectID
            },
            success: function (data) {
                $('.toast').toast("show");
                $('.toast-body').text("Project Subtask Updated Successfully");
                $("#subtask"+subtaskID).attr('data-target','#subtask_details');
                $("#subtask"+subtaskID).css('cursor','pointer');
                $("#subtask"+subtaskID).attr('onclick',`getSubTaskDetails(`+subtaskID+`)`);

            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    };
    function saveTask(text, i) {
        console.log(i);
        $.ajax({
            type: 'GET',
            url: '../update-subtask-title',
            data: {
                subtask_id: i,
                subtask_title: text
            },
            success: function (data) {
                $('.toast').toast("show");;
                $('.toast-body').text("Project Subtask Updated Successfully");
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            },
        });
    };

    function updateTaskDescription(event) {
        subtask_id = $("#subtask_title").attr("data-id");
        console.log(subtask_id);
        $(event.target).attr('contenteditable', 'true');
        $(event.target).keydown(function () {
            if (window.event.keyCode === 13 || window.event.which === 13) {
                event.preventDefault();
                event.stopPropagation();
                $(event.target).attr('contenteditable', 'false');
                $.ajax({
                    url: '../update-subtask-description',
                    type: 'GET',
                    data: {
                        subtask_id: subtask_id,
                        description: $(event.target).text()
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            $(`#subtask_description`).html($(event.target).text());
                            $('.toast').toast("show");;
                            $('.toast-body').text("Project Subtask Updated Successfully");
                        } else {

                            alert("Something went wrong");
                        }
                    }
                });

            }
        });

    }

    // Adding new subtask field into frontend
    function addTask(data) {
        let task = `<div class="d-flex align-items-center mt-3" id="task` + data + `">
            <!--begin::Bullet-->
            <span class="bullet bullet-bar bg-success align-self-stretch"></span>
            <!--end::Bullet-->
            <!--begin::Checkbox-->
            <label class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
                <input type="checkbox" name="select" data-id=`+ data + ` class="task_checkbox" />
                <span></span>
            </label>
            <!--end::Checkbox-->
            <!--begin::Text-->
            <div class="d-flex flex-column flex-grow-1" id="subtask`+data+`"  data-toggle="modal" data-target="#">
                <div class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1 sub_task_title" id="taskname`+ data + `"  data-id=` + data + ` style="margin-top:4px; height:20px;"></div>
            </div>
            <!--end::Text-->
            <!--begin::Dropdown-->
            <div class="dropdown dropdown-inline ml-2">
            <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ki ki-bold-more-hor"></i>
            </a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                <!--begin::Navigation-->
                <ul class="navi navi-hover">
                    <li class="navi-item bg-light-danger rounded">
                            <a  class="sub_task_delete navi-link"  data-id=` + data + `
                                <span class="navi-text">
                                    Delete Task
                                </span>
                            </a>
                    </li>
                </ul>
                <!--end::Navigation-->
            </div>
        </div>
            </div>
            <!--end::Dropdown-->
        </div>`
        $('#task_board').append(task);

    }
    $('#subtask_details').on('hidden.bs.modal', function (e) {
        $(".subtask_member").html("");
        $("#subtask_title").text("");
        $("#subtask_title").attr("data-id",-100);
        $("#subtask_description").text("");
        $("#subtask_description").attr("data-id",-100);
        $("#assign_subtask_member").attr("action","#");
        $("input").val();
    })

