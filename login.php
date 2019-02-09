<?php
if(!defined("MAIN_FILE")) die;
if(isset($_POST['username'])){$username = $_POST['username'];}else{$username = "test@mail.ru";}
if(isset($_SESSION["email"])){$username = $_SESSION["email"];}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OIK</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/login.css">

</head>
<body>

<!-- MAIN LOGIN FORM -->
<div class="login-page">
    <form id="loginForm">
        <h2 class="text-center">Log in</h2>

    <div id="loginFormErrMsg" class="h3 text-center hidden">Wrong password!</div>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" id="username" value="<?=$username?>" required="required">
          </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" id="password" required="required">
        </div>
        <div class="form-group">
            <!-- <button type="button" name="loginb" id="loginb" class="btn btn-success" data-toggle="modal" data-target="#loginModaltest">Login</button> -->
            <!-- <button class="btn btn-primary btn-block" id="login_button">Log in</button> -->
            <button class="btn btn-block" id="login_button">Log in</button>
        </div>
        <div class="clearfix">
            <a href="#ModalReg"  data-toggle="modal" class="pull-left">New account</a>
            <a href="#ModalReset"  data-toggle="modal" class="pull-right">Forgot Password?</a>
        </div>        
    </form>
</div>

<!-- Modal HTML New Account -->
<div id="ModalReg" class="modal fade">
    <div class="login-page">
        <!-- <form action="action.php" method="post"> -->
        <form id="RegForm">
            <h2 class="text-center">Register</h2>
            <div id="NewAcntErrMsg" class="h3 text-center hidden">Invalid email!</div>
            <div class="form-group">
                <select class="form-control" id="reg_user_type" name="reg_user_type">
                    <option value="1">Uczęstnik</option>
                    <option value="2">Organizator</option>
                </select>
            </div>
            <div class="form-group">
                <!-- <input type="hidden" name="action" value="register"> -->
                <input type="email" value="wewew@test.ri" class="form-control" placeholder="email" required="required" id="reg_email" name="reg_email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="required" id="reg_password" name="reg_password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm password" required="required" id="reg_password2">
            </div>
            <div class="form-group">
                <button class="btn btn-block" id="create_button">Create</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal HTML Reset Password -->
<div id="ModalReset" class="modal fade">
    <div class="login-page">
        <form action="action.php" method="post">
            <h2 class="text-center">Reset Password</h2>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="email" required="required">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Reset password</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal HTML Success 2 -->
<div id="successModal" class="modal fade">
    <div class="login-page">
        <form action="index.php" method="post">
            <input type="hidden" name="username" id="sUser">
            <h2 class="text-center">Please check email</h2>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">OK</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Success -->
<div id="successModal2" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="material-icons">&#xE876;</i>
                </div>
                <h4 class="modal-title">OK!</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Check your email for detials.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-block" data-dismiss="modal" id="successBtnOk">OK</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="JS/login.js"></script>


</body>
</html>                                		                            