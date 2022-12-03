$(window).on('load',function() {
    //Delete project file
    $('.delete-btn').on("click",(e)=>{
       var file_id = $(e.target).attr('data-id');
       var url = `../delete-project-file/`+file_id;
       console.log(url)
       $('#delete').attr('action', url);
    });
    //Edit project file
    $('.edit-btn').on("click",(e)=>{
        var file_id = $(e.target).attr('data-id');
        $.ajax({
            url: `../get-project-file/`+file_id,
            type: "GET",
            success: function (data) {
                console.log(data);
                $('#file_description_edit').text(data.file_description);
                $('#show_file_name').text(data.file_path);
                $('#edit_form').attr('action',`../edit-project-file/`+file_id)
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
        $('.save_edit').on('click',()=>{
            $("#edit_form").trigger("submit");
        })
     });
});
