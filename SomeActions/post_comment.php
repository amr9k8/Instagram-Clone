<?php

// echo"<pre>";
// print_r($result);
// exit();
include("../includes/System.php");


session_start(); // get data of logged in user
//checkLogin();

if ( isset($_GET['post_id']) )
{
$user_id = $_SESSION['user'][0];
$post_id =  $_GET['post_id'] ;
$post_txt =  $_GET['comment'] ;

$commentobj =new Comment();

 $commentobj->Add_comment_by_post_id($post_txt,$user_id,$post_id);
header("Location:http://localhost/level1/New IG Version/index.php" );

}