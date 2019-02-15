<?php
fn_log_write("action.php 1 POSTS: ".fn_get_posts_str(), __LINE__);

if(isset($_GET['confirmcode'])) {$_POST['action'] = "confirm";}

if(!isset($_POST['action'])) die;

date_default_timezone_set('Europe/Warsaw');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__); exit();}
$mysqli->query("SET NAMES utf8");

session_start();

fn_log_write("action.php POSTS: ".fn_get_posts_str(), __LINE__);

if($_POST['action'] == "testmail"){
fn_send_activation_code("i.andrievsky@mail.ru", $_GET['code']);
exit();
}

//-------LOGOUT-------------------
if($_POST['action'] == "logout"){
    fn_log_write("logout!", __LINE__);
    unset($_SESSION["role"]);
    header('Location: ../index.php');
    echo "HZ";
    exit();
}

//-------CONFIRM EMAIL-------------------
if($_POST['action'] == "confirm" AND isset($_GET['confirmcode'])){

    fn_log_write("trying to confirm. Code: ".$_GET['confirmcode'], __LINE__);//$_GET['code']

    if($email = fn_confirm_email($_GET['confirmcode'])){
        $_SESSION["email"] = $email;
        header('Location: index.php');
        exit();
    }

    header('Location: error.html');
    exit();
}

//-------REGISTER-------------------
if($_POST['action'] == "register" AND isset($_POST['reg_email'])){

    fn_log_write("trying to register ".$_POST['reg_email'], __LINE__);

    $reg_user_type = 1;
    if(isset($_POST['reg_user_type']) AND is_numeric($_POST['reg_user_type'])){$reg_user_type = $_POST['reg_user_type'];}

    if(valid_email($_POST['reg_email'])){
        $answerArr = fn_add_new_user($_POST['reg_email'], $_POST['reg_password'], $reg_user_type);
    }else{$answerArr['errorMsg'] = "Invalid E-mail!";}

    $srv_answer = json_encode($answerArr);
    fn_log_write($srv_answer, __LINE__);
    echo $srv_answer;
    exit();
}

//-------LOGIN-------------------
if($_POST['action'] == "login"){

    fn_log_write("trying to login ".$_POST['login_email'], __LINE__);

    if(valid_email($_POST['login_email'])){

        $_SESSION["email"] = $_POST['login_email'];

        if(isset($_POST['login_password']) AND !empty($_POST['login_password'])){

            $answerArr = fn_get_user_info($_POST['login_email'], $_POST['login_password']);

            if(isset($answerArr['role'])){$_SESSION["role"] = $answerArr['role'];}

        }else{$answerArr['errorMsg'] = "Empty password!";}
    }else{$answerArr['errorMsg'] = "Invalid E-mail!";}

    $srv_answer = json_encode($answerArr);
    fn_log_write($srv_answer, __LINE__);
    echo $srv_answer;
    exit();
}

echo "NoNe";


exit();

function fn_get_user_info($login_email, $pass)
{
    global $mysqli;

    $login_email = trim(addslashes(stripslashes($login_email)));

    $sql = "SELECT `role`, `is_blocked`, `email_comfirmed`, `hash` FROM `tb_users` WHERE `email` = '$login_email' LIMIT 1";
    //fn_log_write($sql);
    if($result=$mysqli->query($sql))
    {
        if($result->num_rows == 1)
        {
            $row = $result->fetch_object();

            if(password_verify ( $pass , $row->hash ))
            {
                if($row->email_comfirmed == 1)
                {
                    if($row->is_blocked == 0)
                    {
                        $answerArr['role'] = $row->role;
                    }else{$answerArr['errorMsg'] = "User is blocked.";}
                }else{$answerArr['errorMsg'] = "Please confirm email before.";}
            }else{$answerArr['errorMsg'] = "Wrong password.";}
        }else{$answerArr['errorMsg'] = "Unknown email.";}
    }else{$answerArr['errorMsg'] = "DB error. Please contact to admin";}

    return $answerArr;
}

function fn_confirm_email($code)
{
    global $mysqli;

    fn_log_write("fn_confirm_email: ".$code, __LINE__);

    $code = trim(addslashes(stripslashes($code)));

    $sql = "SELECT `id`, `email` FROM `tb_users` WHERE `token` = '$code' AND `email_comfirmed` = 0 LIMIT 1";
    if($result=$mysqli->query($sql))
    {
        if($result->num_rows == 1) {
            $row = $result->fetch_object();
            $email = $row->email;
            $sql = "UPDATE `tb_users` SET `email_comfirmed` = 1 WHERE `id` = '".$row->id."' LIMIT 1";
            if($mysqli->query($sql)){
                return $email;
            }else{
                fn_log_write("mysql_err: ".$sql."\r\nerr_desc: ".$mysqli->error, __LINE__);
            }
        }
    }
    return false;
}

function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function fn_log_write($msg, $line = __LINE__)
{
    $fp = fopen("logs/action.txt","a");
    fputs($fp,date("Y-m-d H:i:s")."\t".$msg." line:".$line." ".basename(__FILE__)."\r\n");
    fclose($fp);
}

function fn_get_posts_str()
{
    $postlink_text = "";
    foreach ($_POST as $key => $value) {$postlink_text .= $key." = ".$value."\t";}
    
    if(count($_GET)>0){
    	$postlink_text .= "GETS:\t";
		foreach ($_GET as $key => $value) {$postlink_text .= $key." = ".$value."\t";}
	}
    return $postlink_text;
}

function fn_add_new_user($reg_email, $reg_password, $role)
{
    global $mysqli;

    $reg_email = trim(addslashes(stripslashes($reg_email)));

    $hash = password_hash($reg_password, PASSWORD_DEFAULT);

    $activation = md5($reg_email.time());

    $sql = "INSERT INTO `tb_users` (`email`,`hash`,`token`,`reg_datetime`,`role`)
        VALUES ('$reg_email','$hash','$activation','".date("Y-m-d H:i:s")."','$role')";

    if(!$mysqli->query($sql)){

        fn_log_write("mysql_err: ".$mysqli->error, __LINE__);

        if (strpos($mysqli->error, "Duplicate entry") !== false){
            $answerArr['errorMsg'] = "User with that email already exists.";
        }else{
            $answerArr['errorMsg'] = "Server error. Please try later.";
        }

    }else{
        fn_send_activation_code($reg_email, $activation);
        $answerArr['result'] = "OK";
    }

    return $answerArr;
}

function fn_send_activation_code($email, $activation)
{
    $url = "https://oik.fiszki.net/action.php?confirmcode=$activation";

    $message = "<html><head><title>Confirmation</title></head>
                <body>
                <h2>Welcome!</h2>
                <p><a href=\"$url\">Please confirm email via this link</a></p>
                </body>
                </html>";
    
    $to      = $email;
	$subject = 'Please confirm email';
	$message = $message;
	$headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: activation@oik.fiszki.net' . "\r\n";
	$headers .= 'Reply-To: activation@oik.fiszki.net' . "\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion();

	if (preg_match("/@poczta.pl$/i", $email)) {
		$mail_state = "WITHOUT SENDING";
	}elseif (mail($email,$subject,$message,$headers)){
    	$mail_state = "SENT";
    }else{
    	$mail_state = "ERROR";
    }
    
    $fp = fopen("logs/mail.txt","a");
    fputs($fp,date("Y-m-d H:i:s")."\tSENT MAIL with Activation URL: ".$url." State: ".$mail_state."\r\n");
    fclose($fp);
}
?>