

function deleteMember($id){
    $.ajax({
        type : 'get',
        url : '/admin/delete-member',
        data:{'data':$id},
        success:function(data){
            var row =  "row"+$id;
           // alert(row);
            $("#"+row).fadeTo("slow",0.2, function(){
                $(this).remove();
                $("#employeeDelete").modal('hide');
                toastr.success("Employee Successfully Deleted");
            })

        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        },
})
}
function updateMember($id , $option , $value){

    if($option != "position"){
        $("#"+$option+$id).attr('contenteditable','false');
    }else{
        $("#position"+$id).css('display','block');
        $("#position-edit"+$id).css('display','none');
    }

    $.ajax({
        type : 'get',
        url : '/admin/update-member',
        data:{
               'id':$id ,
               'option':$option ,
               'value':$value
         },
        success:function(data){
            console.log(data);
            if(data.data === "error"){
                toastr.error(data.msg,{
                    preventDuplicates: true,
                });
            }else{
                toastr.success(data.data,{
                    preventDuplicates: true,
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        },
})


}
function updateName($id){

    $("#name"+$id).attr('contenteditable','true');
    var input = document.getElementById("name"+$id);

    input.addEventListener("keypress", function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
           // console.log($("#name"+$id).text());
            $("#name"+$id).html(function(){
                $("#name"+$id).html  = $("#name"+$id).html().replace(/(?:&nbsp;|<br>)/g,'');
            });
           updateMember($id,"name",$("#name"+$id).text() )

        }
      });
}
function updateEmail($id){
    $("#email"+$id).attr('contenteditable','true');
    var input = document.getElementById("email"+$id);

    input.addEventListener("keypress", function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
           // console.log($("#name"+$id).text());
            updateMember($id,"email",$("#email"+$id).text() )

        }
      });
}
function updatePhone($id){
    $("#number"+$id).attr('contenteditable','true');
    var input = document.getElementById("number"+$id);

    input.addEventListener("keypress", function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
           // console.log($("#name"+$id).text());
            updateMember($id,"phone",$("#number"+$id).text() )

        }
      });
}
function updatePosition($id){
    $("#position"+$id).css('display','none');
    $("#position-edit"+$id).css('display','block');
    var input = document.getElementById("positionD"+$id);
    input.addEventListener("change", function(event) {

           $msg = "positionD"+$id+" :selected"

    //console.log();
          updateMember($id,"role_id",$('#'+$msg).val());
         $("#position"+$id).text($('#'+$msg).text());
         $("#position"+$id).css('display','block');
         $("#position-edit"+$id).css('display','none');
      });

}

// function switchT($id,$stage){
//     if($stage == 1){
//          $stage = 0;
//     }else{
//          $stage = 1;
//     }
//     updateMember($id,"stage",$stage);
// }


function switchT(id, stage){
    stage = stage ? 0 : 1;
    updateMember(id, "stage", stage);
}
