$(document).ready(function(){
    $('#loginb').click(function(){
        var username = $('#username').val();
        var password = $('#password').val();
        if(username != '' && password != '')
        {
            $.ajax({
                url:"action.php",
                method:"POST",
                data: {username:username, password:password, action:'login'},
                success:function(data)
                {
                    //alert(data);
                    if(data == 'No')
                    {
                        //alert("Wrong Data");
                        alert(data);
                    }
                    else
                    {
                        $('#loginModal').hide();
                        alert(data);
                        //location.reload();
                    }
                }
            });
        }
        else
        {
            alert("Both Fields are required");
        }
    });

    $('#logout').click(function(){
        var action = "logout";
        $.ajax({
            url:"action.php",
            method:"POST",
            data:{action:action},
            success:function()
            {
                location.reload();
            }
        });
    });
    //test


    $("#login_button").click(function(){ //при клике на кнопку <button id="submit_form">Отправить</button> выполняем функцию
        $.post("action.php", $("#loginForm").serialize(),  function(response) { //здесь #form_id - это ID формы, которая будет отправляться
            $("#result").html(response); //вывод ответа от php-скрипта в <div id="result"></div>
        });
        return false;
    });

});