<?php
// echo"<pre>";
// print_r($all_posts);
// exit();

include("includes/System.php");
session_start();
checkLogin();
$myid = $_SESSION['user'][0];
if($_GET['id'] && $_GET['id'] !== $myid )
{
$userobj = new users();
$postobj = new posts();
$followobj = new follow();
$likeobj = new Like();
$commentobj = new Comment();

$other_id = $_GET['id'];
$result = $userobj->get_user_by_id($myid); //get myavatar from database
 $avatar    = $result[4];
  // use avatar of user in the nav 
  $profile_icon = "<img src='uploads/".$avatar." '> ";

 //Count followers and following
 $countfollowers = $userobj->count_followers($other_id);
 $countfollowing = $userobj->count_following($other_id);

 //get all posts of user
$countposts = $postobj->count_posts($other_id);
$all_posts = $postobj->get_profile($other_id);



echo 
"
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>

        <title>New IG Version</title>
        <link href='templates/assets/css/other-profile.css' rel='stylesheet'>
        <link href='templates/assets/css/user.index.css' rel='stylesheet'>
        <link href='templates/assets/css/all.min.css'     rel='stylesheet'>
        <link href='templates/assets/css/followmodal.css'       rel='stylesheet'>

    <body>
    
";

 include("templates/nav.html");
 include("templates/search.html");

  //###########  DISPLAY FOLLOWING & FOLLOWERS IN MODALS #################
 $followingIDs_array = $userobj->get_following_by_id($other_id);
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
 $followersIDs_array = $userobj->get_followers_by_id($other_id);  
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



############# SET PROFILE DATA (NAME,AVATAR,ETC)
$result = $userobj->get_user_by_id($other_id); //get data from database
 $username =  $result[1];
 $email    =  $result[2];
 $password =  $result[3];
 $avataar    = $result[4];
 $follow_statues=check_follow($myid,$other_id)?'Following':'Follow';
 echo "
 <section class='myprofile-container'> 
 <div class='myprofile-data-container'>
                    <div class='myprofile-avatar'>
                        <img src='uploads/$avataar'>
                    </div>
                    <div class='myprofile-info'>
                            <div class='myprofile-name-btn'>
                                <h3>$username</h3>
                                <button><a href='SomeActions/follow_unfollow.php?id=".$other_id."'>". $follow_statues."</a></button>
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



echo"

<div class='myprofile-items-container'>

<div class='post-icon' >

    <a href='#'> <i class='fas fa-th'></i>POSTS</a>
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
include("templates/otherprofile.html");
include("templates/followModal.html");

}
else
header("Location:myprofile.php");