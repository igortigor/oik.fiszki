$(document).ready(function () {

    console.log("dokument ready");

    $('#login_button').click(function(){
        console.log("login_button click");

        var loginForm = document.getElementById("loginForm");

        if (loginForm.checkValidity() === true) {
            var login_email = $('#username').val();
            var login_password = $('#password').val();

            $.ajax({
                url:"action.php",
                type:"POST",
                data: {login_email:login_email, login_password:login_password, action:'login'},
                success:function(respRaw)
                {
                    console.log("login success:function" + respRaw);

                    if(response = tryJSONparse(respRaw)){

                        if(response['errorMsg']){
                            errShake("loginFormErrMsg", response['errorMsg'])
                        }else{
                            console.log("reload");
                            location.reload();
                        }
                    }else{ errShake("loginFormErrMsg", "UNKNOWN ERROR, TRY LATER") }
                },

                error:function(data)
                {
                    console.log("error function data");
                    alert("error function data");
                }
            });

            return false;

        }else{
            errShake("loginFormErrMsg", "Invalid form")
            console.log("invalid login form");
        }

    });



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

function tryJSONparse(data){
    try {
        return jQuery.parseJSON(data);
    } catch (objError) {
        console.log(objError);
        return false;
    }
}

function errShake(elID, errText){
    var MsgDIV = document.getElementById(elID);
    MsgDIV.classList.remove("hidden");
    MsgDIV.childNodes[0].textContent = errText;
    $( "#" + elID ).shake(3, 7, 500);
}

jQuery.fn.shake = function(intShakes, intDistance, intDuration) {
    this.each(function() {
        $(this).css("position","relative");
        for (var x=1; x<=intShakes; x++) {
            $(this).animate({left:(intDistance*-1)}, (((intDuration/intShakes)/4)))
                .animate({left:intDistance}, ((intDuration/intShakes)/2))
                .animate({left:0}, (((intDuration/intShakes)/4)));
        }
    });
    return this;
};