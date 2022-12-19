
//Updateing project description ( ajax call )
function updateProjectDescription(project_id, project_description) {


}

// Double click on project name to update project name
$("#tdg_project_name").on("dblclick", function () {
    $(this).prop("contenteditable", true);
    $('#tdg_project_name').css("width", '600px');
    $(this).focus();
    $(this).on("keypress", function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if ($(this).text() === "") {
                toastr.error("Project Title cann't be empty");
            } else {
                $(this).prop("contenteditable", false);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "../update-title",
                        data: {
                            project_id: $(this).data("ivalue"),
                            project_name: $(this).text(),
                        },
                        success: function (data) {
                            if(data.success) {
                                toastr.success("Project title updated successfully");
                            }else{
                                toastr.warning("Something went wrong, please try again");
                            }
                        }
                    });

            }


        }
    });

});
// Double click on project description to update project description
$("#tdg_project_description").on("dblclick", function () {
    $(this).prop("contenteditable", true);
    $(this).focus();
    $(this).on("keypress", function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if ($(this).text() === "") {
                toastr.error("Description cannot be empty");
            } else {
                $(this).prop("contenteditable", false);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "../update-description",
                    data: {
                        project_id: $(this).data("ivalue"),
                        project_description: $(this).text(),
                    },
                    success: function (data) {

                        if(data.success) {

                            toastr.success("Project decription updated successfully");
                        }else{
                            toastr.warning("Something went wrong, please try again");
                        }
                    }
                });
            }
        }
    });

});

//Submitting Project update form
$("#save_settings").on("click",()=>{
    $('#project_settings_form').submit();
})
