<?php

// echo"<pre>";
// print_r($result);
// exit();
include("includes/System.php");


session_start(); // get data of logged in user
checkLogin();

$userobj = new users();
$postobj = new posts();
$followobj = new follow();
$likeobj = new Like();
$commentobj = new Comment();

 $myid   =  $_SESSION['user'][0];
 $result = $userobj->get_user_by_id($myid); //get data from database
 $username =  $result[1];
 $email    =  $result[2];
 $password =  $result[3];
 $avatar    = $result[4];

//  // use avatar of user in the nav 
$profile_icon = "<img src='uploads/".$avatar." '> ";

 include("templates/explore.html");
 include("templates/search.html");
 include("templates/nav.html");
$allposts =$postobj->get_explore_by_id($myid);
// print_r($allposts);
echo"<div class='explore-posts-container'>";
foreach ($allposts as $one_post) {
    $post_id    =  $one_post['post_id'];
    $post_title =  $one_post['post_title'];
    $countlikes =   $likeobj->count_likes_by_post_id($post_id);
    $countcomments =  $commentobj->count_comments_by_post_id($post_id);


    echo"
    <div class='explore-post'>
        <div class='explore-transparent-layer'>
            <a> <i class='fas fa-heart'></i> ".$countlikes."</a>
            <a> <i class='fas fa-comment'></i> ".$countcomments." </a>
        </div>
        <img src='uploads/".$post_title ."' >
    </div>

    ";


}



    










