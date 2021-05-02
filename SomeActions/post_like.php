<?php

// echo"<pre>";
// print_r($result);
// exit();
include("../includes/System.php");


session_start(); // get data of logged in user
checkLogin();

if ( isset($_GET['post_id']) )
{
$user_id = $_SESSION['user'][0];
$post_id =  $_GET['post_id'] ;

$likeobj = new Like();

 if (!$likeobj->Add_like_by_post_id($user_id,$post_id) ) //if 0 then like already exist then it will be removed
 {
     $likeobj->remove_like_by_post_id($user_id,$post_id) ;
 }
 

header("Location:index.php" );
header("Location:http://localhost/level1/New IG Version/index.php" );
}