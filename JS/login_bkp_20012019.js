$('#ModalReg').on('hidden.bs.modal', function (e) {
    // do something...
})


$(document).ready(function () {

    console.log("jestesmy w 3 linijce");

    $('#successBtnOk').click(function(){
        console.log("reload");
        location.reload();
    });

    //Login panel
    $('#login_button').click(function(){
        var username = $('#username').val();
        var password = $('#password').val();
        if(username != '' && password != '')
        {
            console.log("username = login");
            $.ajax({
                url:"action.php",
                method:"POST",
                data: {username:username, password:password, action:'login'},
                success:function(data)
                {
                    console.log("POST success");
                    //alert(data);
                    //if(data == 'wrongpassword')
                    if(data == 'ok')
                    {
                        console.log("data = ok");
                        //alert("Wrong Data NO");
                        //alert(data + "-No");
                    }
                    else
                    {
                        console.log("else");
                        $( "#msgWrongPass" ).removeClass( "hidden" );
                        $("#msgWrongPass").shake(3, 7, 500);
                        //$('#loginModal').hide();
                        //alert("Wrong Data");
                        //alert(data + "-YES");
                        //location.reload();
                    }
                }
            });
        }
        else
        {
            console.log("username != login");
            alert("Both Fields are required");
        }
    });





    //New user panel
    $('#create_buttonn').click(function(){
        console.log("new user create btn click");
        var reg_email = $('#reg_email').val();
        var reg_password = $('#reg_password').val();
        var reg_password2 = $('#reg_password2').val();
        var reg_user_type = $('#reg_user_type').val();

        //if(password == password2){
        if(reg_password === reg_password2){
            console.log("reg_password = reg_password2");
            if(reg_email != '' && reg_password != '' && reg_user_type != '') {
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data: {email:reg_email, password:reg_password, user_type:reg_user_type, action:'register'},
                    success:function(data)
                    {
                        console.log("success:function" + data);
                        switch (data) {
                            case 'ok':
                                console.log("case ok");
                                //$('#ModalReg').hide();
                                $("#successModal").modal();
                                break;
                            case 'invalidemail':
                                console.log("case invalidemail");
                                document.getElementById("NewAcntErrMsg").childNodes[0].textContent = "Invalid Email";
                                alert('invalidemail');
                                break;
                            case 'userexists':
                                console.log("case userexists");
                                document.getElementById("NewAcntErrMsg").childNodes[0].textContent = "Existed User";
                                alert( 'Перебор' );
                                break;
                            default:
                                console.log("case def");
                                alert( 'Я таких значений не знаю' );
                        }

                        $( "#msgRegError" ).removeClass( "hidden" );
                        $("#msgRegError").shake(3, 7, 500);

                    }
                });

            }
            else
            {
                console.log("some parameter is missing");
                alert("Parameters missing!" + reg_email + reg_password + reg_user_type);
            }
        }else
        {
            console.log("pass1 != pass2");
            alert("Passwords missmach! " + reg_password + " " + reg_password2);
            //return false;
        }

    });
/*
    $('#successModalBtn').click(function(){
        $("#successModal").hide();
        //location.reload();
    });
*/
});

function formError(){
    $("#loginForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
}

function formSuccess(){
    $( "#msgSubmit" ).removeClass( "hidden" );
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