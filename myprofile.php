<?php
// echo"<pre>";
// print_r($all_posts);
// exit();

include("includes/System.php");

session_start();
checkLogin();

$userobj = new users();
$postobj = new posts();
$followobj = new follow();
$likeobj = new Like();
$commentobj = new Comment();

$myid       =  $_SESSION['user'][0];
$result = $userobj->get_user_by_id($myid); //get data from database
 $username =  $result[1];
 $email    =  $result[2];
 $password =  $result[3];
 $avatar    = $result[4];


 //Count followers and following
 $countfollowers = $userobj->count_followers($myid);
 $countfollowing = $userobj->count_following($myid);

 //get all posts of user
$countposts = $postobj->count_posts($myid);
$all_posts = $postobj->get_profile($myid);

  // use avatar of user in the nav 
 $profile_icon = "<img src='uploads/".$avatar." '> ";

echo 
"  
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>

        <title>New IG Version</title>
        <link href='templates/assets/css/myprofile.css' rel='stylesheet'>
        <link href='templates/assets/css/user.index.css' rel='stylesheet'>
        <link href='templates/assets/css/all.min.css'     rel='stylesheet'>
        <link href='templates/assets/css/followmodal.css'       rel='stylesheet'>
    </head>

    <body>
    
";
include("templates/search.html");
 include("templates/nav.html");
 
 echo "
 <section class='myprofile-container'> 
 <div class='myprofile-data-container'>
                    <div class='myprofile-avatar'>
                        <img src='uploads/$avatar'>
                    </div>
                    <div class='myprofile-info'>
                            <div class='myprofile-name-btn'>
                                <h3>$username</h3>
                                <button><a href='updateprofile.php'>Edit Profile</a></button>
                            </div>
                            <div class='myprofile-following'>
                                <a> $countposts</a>  <span>post</span>
                                <a href='#followerModal_ID'>$countfollowers</a><span>followers</span>
                                <a href='#followingModal_ID'>$countfollowing</a><span>following </span>
                            </div>
                            <div class='myprofile-caption'>
                                <a></a>
                            </div>
                    </div>
                </div>";



 //###########  DISPLAY FOLLOWING & FOLLOWERS IN MODALS #################

 $followingIDs_array = $userobj->get_following_by_id($myid);
 //if user have any followings ,display them in modal 
if( $followingIDs_array)
 { 
    echo"
    <div id='followingModal_ID' class='followerModalClass'> 
   
    <div class='follower_container'>
        <a href='#close' title='Close' class='close'>X</a>
        

        <div class='sec_container'>

                <div class='header'>
                                                    
                            <div class='name_comment'>
                                <h2 class='name_comment'>Following</h2>   
                            </div>                  
                </div>
    
                <div class='followers_section'>
    ";
    foreach($followingIDs_array as $one_following_ID)
    {
        $result = $userobj->get_user_by_id($one_following_ID); //get data from database
        $modal_id =  $result[0];
        $username =  $result[1];
        $email    =  $result[2];
        $avatar   =  $result[4];    
        $follow_statues=check_follow($myid,$modal_id)?'Following':'Follow';
        if ($myid == $modal_id) //if my id is in modal dont display button
          $button = '';
        else 
          $button = "<button><a href='SomeActions/follow_unfollow.php?id=".$modal_id."'> $follow_statues</a></button>";

        echo 
        "
        <div  class='follow_row'>  
                                       
        <div class='follow_avatar'>
            <img src='uploads/".$avatar."'> 
            <div class='name_comment'>
                <a href='otherprofile.php?id=".$modal_id."' class='name_comment'>".$username."</a>  
                <span>". $email ."</span>  
            </div>   
                        
        </div>
            <div class='follow_link'>
                $button
            </div>
    </div> 
        ";
    }
    echo "   </div>
    </div>
    
    </div>
                
    </div>";
}


 //if user have any followers ,display them in modal 
 $followersIDs_array = $userobj->get_followers_by_id($myid);  
 if( $followersIDs_array)
 { 
    echo"
    <div id='followerModal_ID' class='followerModalClass'> 
   
    <div class='follower_container'>
        <a href='#close' title='Close' class='close'>X</a>
        

        <div class='sec_container'>

                <div class='header'>
                                                    
                            <div class='name_comment'>
                                <h2 class='name_comment'>Followers</h2>   
                            </div>                  
                </div>
    
                <div class='followers_section'>
    ";
    foreach($followersIDs_array as $one_follower_ID)
    {
   
        $result = $userobj->get_user_by_id($one_follower_ID); //get data from database
        $modal_id =  $result[0];
        $username =  $result[1];
        $email    =  $result[2];
        $avatar    = $result[4];
        $follow_statues=check_follow($myid,$modal_id)?'Following':'Follow';
        if ($myid == $modal_id) //if my id is in modal dont display button
          $button = '';
        else 
          $button = "<button><a href='SomeActions/follow_unfollow.php?id=".$modal_id."'> $follow_statues</a></button>";

         
        echo 
        "
        <div  class='follow_row'>  
                                       
        <div class='follow_avatar'>
            <img src='uploads/".$avatar."'> 
            <div class='name_comment'>
                <a href='#' class='name_comment'>".$username."</a>  
                <span>". $email ."</span>  
            </div>   
                        
        </div>
            <div class='follow_link'>
                $button
            </div>
    </div> 
        ";
    }
    echo "   </div>
    </div>
    
    </div>
                
    </div>";
}



echo"
 <div class='myprofile-items-container'>

 <div class='post-icon' >
 
     <a href='#'> <i class='fas fa-th'></i>POSTS</a>
 </div>
 <div class='IGTV-icon' >
     <span></span>
     <a>IGTV</a>
 </div>
 <div class='saved-icon' >
     <span></span>
     <a>SAVED</a>
 </div>
 <div class='tag-icon' >
     <span></span>
     <a>TAGGED</a>
 </div>
</div>
<div class='myprofile-posts-container'>
 ";
 

if ($all_posts)
{
    foreach ($all_posts as $one_post)
    {     
        $post_id     = $one_post[0];
        $post_title  = $one_post[1];
        $countlikes    = $likeobj->count_likes_by_post_id($post_id);
        $countcomments = $commentobj->count_comments_by_post_id($post_id);
    echo "
    <div class='post'>
        <div class='transparent-layer'>
            <a> <i class='fas fa-heart'></i> $countlikes </a>
            <a> <i class='fas fa-comment'></i> $countcomments </a>
        </div>
        <img src='uploads/".$post_title."' >
     </div>        
    ";   
    }
}

echo "
</section>

</body>

</html>";
include("templates/myprofile.html");
include("templates/followModal.html");