<?php

include("includes/System.php");

session_start();
have_session_check();

$error = "";
$done = "";

if(isset($_POST['sign_up']))
{

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];
   
    $obj = new users();
    $result=$obj->register_user($username,$email,$password);

    if($result)  // true
    $done=" <p style='color:green; font-size:12px;margin-top:3px' >
            registration done successfully <br> Login now from here <a style='color:black' href='login.php'>login </a>
            </p>";
    else
    $error=" <p style='color:red; font-size:11px'>
    please fill all fields
    </p>";

}


include("templates/register.html");

$_POST = array(); //prevent resubmit when pressed again