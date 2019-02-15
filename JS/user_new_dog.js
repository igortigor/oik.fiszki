var newDog = true;
var cnt = 0;
function toUpperCase(pole)
{
    pole.value=pole.value.toUpperCase();
}

function setPrepairing(chkbox)
{
    if(chkbox.checked){
        document.getElementById("rodowod").disabled = true;
    }else{
        document.getElementById("rodowod").disabled = false;
    }
}

$(".chosen-select").chosen({
    no_results_text: "Oops, nothing found!"
})

document.getElementById("addDogForm").addEventListener("keyup", function(){
    allowSubmit();
});


function checkFormNewDog()
{


}

function allowSubmit()
{
    var cf = document.getElementById("confirmed_flag");

	if(cf != null && cf.value == 1)return false;

    if (document.getElementById("addDogForm").checkValidity() === true) {
        if(document.getElementById("inputColor").value.length > 0){
            document.getElementById("addDogSubmit").disabled = false;
        }
    }else{
        document.getElementById("addDogSubmit").disabled = true;
    }
}
/*
$(document).ready(function () {
    //SEND REG DATA (NEW ACCOUNT)
    $('#create_button').click(function(){
        console.log("create_button click");
        var regForm = document.getElementById("RegForm");
        var reg_email = $('#reg_email').val();
        if (regForm.checkValidity() === true) {
            if($('#reg_password').val() === $('#reg_password2').val()){
                console.log("valid");
                var form_data = $('#RegForm').serializeArray();
                form_data.push({name: 'action', value: 'register'});
                console.log("form_data:" + form_data);

                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data:form_data,
                    //data: {email:reg_email, password:reg_password, user_type:reg_user_type, action:'register'},
                    success:function(respRaw)
                    {
                        console.log("success:function" + respRaw);

                        if(response = tryJSONparse(respRaw)){

                            if(response['errorMsg']){
                                errShake("NewAcntErrMsg", response['errorMsg'])
                            }else{
                                $("#successModal").modal();
                                $("#sUser").val(reg_email);
                            }
                        }else{ errShake("NewAcntErrMsg", "UNKNOWN ANSWER, TRY LATER") }
                    },

                    error:function(data)
                    {
                        console.log("error function data");
                        alert("error function data");
                    }
                });

                return false;

            }else{ errShake("NewAcntErrMsg", "Passwords missmach!") }

        }else{
            errShake("NewAcntErrMsg", "Invalid form")
            console.log("invalid");
        }
    });

});
*/