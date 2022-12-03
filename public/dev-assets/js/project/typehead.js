$(window).on("load",()=>{
    var project_id = $("#tdg_project_name").data("ivalue");
    $("input[name='tdg_assignee_member']").typeahead({
        minLength: 1,
        highlight: true,
        source: function (que, result) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '../exiting-member',
                data: {
                    que: que,
                    p_id:project_id
                },
                //   dataType: "json",
                success: function (data) {
                    let tempData = [];
                    data.map(item => tempData.push(`${item.id}. ${item.name}`));
                    result(tempData);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });

        }

    });
    $("#add_member").typeahead({
        minLength: 1,
        highlight: true,
        source: function (que, result) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '../all-member',
                data: {
                    que: que,
                },
                //   dataType: "json",
                success: function (data) {
                    let tempData = [];
                    data.map(item => tempData.push(`${item.id}. ${item.name}`));
                    result(tempData);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });

        }

    });

    $("#client").typeahead({
        minLength: 1,
        highlight: true,
        source: function (que, result) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '../all-client',
                data: {
                    que: que,
                    p_id: project_id,
                },
                //   dataType: "json",
                success: function (data) {
                    let tempData = [];
                    data.map(item => tempData.push(`${item.id}. ${item.name}`));
                    //console.log(tempData);
                    result(tempData);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });

        }

    });

    $("input[name='subTaskAssign']").typeahead({
        minLength: 1,
        highlight: true,
        source: function (que, result) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '../exiting-member-subtask',
                data: {
                    que: que,
                    subtask_id: $("#subtask_title").attr("data-id")
                },
                success: function (data) {
                    //console.log(data);
                    let tempData = [];
                    data.map(item => tempData.push(`${item.id}. ${item.name}`));
                    result(tempData);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
            });

        }

    });
})
