<?php
if(!defined("MAIN_FILE")) die;
if(isset($_POST['username'])){$username = $_POST['username'];}else{$username = "test@mail.ru";}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Simple Login Form</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/login.css">

</head>
<body>

<!--
<div align="center">
    <button type="button" name="loginb" id="loginb" class="btn btn-success" data-toggle="modal" data-target="#loginModaltest">Login</button>
</div>
-->

<div id="result"></div>

<!-- MAIN LOGIN FORM TEST
<div class="login-form">

        <h2 class="text-center">Log in</h2>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" id="username" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" id="password" required="required">
        </div>
        <div class="form-group">
            <button onclick="myFunction()" type="submit" class="btn btn-primary btn-block" id="login_button_main">Log in</button>
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block" id="login_button_main2">Log in2</button>
        </div>

        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            <a href="#ModalReset"  data-toggle="modal" class="pull-right">Forgot Password?</a>
        </div>
    <p class="text-center"><a href="#ModalReg"  data-toggle="modal">Create an Account</a></p>
</div>
-->

<!-- MAIN LOGIN FORM BKP -->
<div class="login-form">
    <form action="#" method="post" id="loginForm">
        <h2 class="text-center">Log in</h2>       
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" id="username" value="<?=$username?>" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" id="password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" id="login_button_main">Log in</button>
        </div>

        <div class="form-group">
            <!-- <button type="button" name="loginb" id="loginb" class="btn btn-success" data-toggle="modal" data-target="#loginModaltest">Login</button> -->
            <button class="btn btn-primary btn-block" id="login_button_main2">Log in2</button>
        </div>

        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            <a href="#ModalReset"  data-toggle="modal" class="pull-right">Forgot Password?</a>
        </div>        
    </form>
	<p class="text-center"><a href="#ModalReg"  data-toggle="modal">Create an Account</a></p>
</div>

<!-- Modal HTML New Account -->
<div id="ModalReg" class="modal fade">
    <div class="login-form">
        <form action="action.php" method="post">
            <h2 class="text-center">Register</h2>
            <div class="form-group">
                <select class="form-control">
                    <option>Uczestnik</option>
                    <option>Organizator</option>
                </select>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="email" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Confirm password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Create</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal HTML Reset Password -->
<div id="ModalReset" class="modal fade">
    <div class="login-form">
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


<!-- test modal -->
<div id="loginModaltest" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <label>Username</label>
                <input type="text" name="username" id="username" class="form-control" />
                <br />
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" />
                <br />
                <button type="button" name="login_button" id="login_button" class="btn btn-warning">Login</button>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="JS/login.js"></script>
<!-- <script src="/JS/login.js"></script> -->


</body>
</html>                                		                            