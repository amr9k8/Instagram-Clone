<?php
require("includes/System.php");

session_start();
have_session_check();
$error=''; //i wrote it here to prevent undefined variable error  

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
   
    $obj = new users();
    $result=$obj->login($username,$password);

    if($result && count($result)>0)  // not empty
    {
        $_SESSION['user']=$result;
        header("Location:index.php");
    }
    else
    $error="Wrong Username or Password";
}
 include("templates/login.html"); 

?>