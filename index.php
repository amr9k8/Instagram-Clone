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

$myid       =  $_SESSION['user'][0];
$result = $userobj->get_user_by_id($myid); //get data from database
 $username =  $result[1];
 $email    =  $result[2];
 $password =  $result[3];
 $avatar    = $result[4];


//  // use avatar of user in the nav 
$profile_icon = "<img src='uploads/".$avatar." '> ";

include("templates/index.html");
include("templates/nav.html");
include("templates/search.html");
  echo
  "
  <section class='storysection'>";
  //Set Random Users in Story Section 
 $allfollowing = $userobj->get_following_by_id($myid);
 if ($allfollowing)
 {
    foreach ($allfollowing as $one) {
        $result = $userobj->get_user_by_id($one);
        $story_id       =  $result[0];
        $story_username =  $result[1];
        $story_avatar   =  $result[4];


 echo
        "

        <div class='storycontent'>

            <div class='story-active-color'>
                <img src='uploads/".$story_avatar."'>
            </div>
        

                <a href='otherprofile.php?id=".$story_id."'>".$story_username."</a>
        </div>

        ";
    }
 }
echo
"
</section>

<aside class='side'>

<div class='side-container'>
    
<div class='first-side-content'>

    <div class='side_avatar'>
        <a href='myprofile.php'>$profile_icon</a>
       </div>

        <ul>
            <li><a href='#'>$username</a></li>
            <li>    $email </li>
        </ul>
        <div class='switch'><a href='logout.php'>Logout</a></div>
</div>


    <div class='Suggestions-For-You'>
        
        <span>Suggestions For You</span>
        <a href='#'>See All </a>
    </div>
";



  //GET SUGGESTION LIST 
$ALL_Suggestion_IDS = $userobj->suggestion_list($myid);
if ($ALL_Suggestion_IDS) 
{   
    foreach ($ALL_Suggestion_IDS as  $one) {
        $result = $userobj->get_user_by_id($one);
        $S_id       =  $result[0];
        $S_username =  $result[1];
        $S_email    =  $result[2];
        $S_avatar   =  $result[4];
         

        echo "
            
        <div class='other-side-content'>
        <img src='uploads/".$S_avatar."'>
    
        <ul>
            <li><a href='otherprofile.php?id=".$S_id."'>$S_username</a></li>
            <li>$S_email</li>
            
        </ul>
        <div class='Follow'><a href='#'>Follow</a></div>
        
</div>
        
        ";

    }
    
}

echo 
"
<div class='side-footer'>
<span> 
 <a href='#'>About</a>.<a  href='#'>Help</a>.<a  href='#'>Press</a>.<a  href='#'>API</a>.
 <a  href='#'>Jobs</a>.<a  href='#'>Privacy</a>.<a  href='#'>Terms</a><br>
 <a  href='#'>Location</a>.<a  href='#'>Top Accounts</a>.<a  href='#'>Hashtag</a>.
 <a  href='#'>Language</a>.<br><br>
 <a>&copy;2020 Instagram From Facebook</a>
</span>
</div>

</div>
</aside>

";


  $all_post_data = $postobj->get_feed_by_id($myid);
if ($all_post_data)
{
  foreach ($all_post_data as $one_post_data)
     {
    $user_id     = $one_post_data['user_id'];
    $username    = $one_post_data['username'];
    $user_avatar = $one_post_data['user_avatar'];
    $post_id     = $one_post_data['post_id'];
    $post_title  = $one_post_data['post_title'];
    $post_caption  = $one_post_data['caption'];
    $post_date  = $one_post_data['upload_date'];

// Normal Like Icon Is Set By Default For Each Post In Loop
$love_content="<i class='far fa-heart'></i>";

echo "
<section class='timeline'>
<div class='post-body'>
<div class='profile-section '>
        <img src='uploads/".$user_avatar."'>
         <div class='name'>
             <a href='otherprofile.php?id=".$user_id."' class='name'>".$username."</a>   
         </div>                  
         <div class='option'>
            <a href='#' >...</a>
         </div> 
</div>


<div class='photo-section'>

    <img src='uploads/".$post_title."'>

    
</div>
";


// GET LIKES DATA FOR EACH POST


// genrate red heart if myid found in likes list
$Total_Likers_ids = $likeobj->get_all_likes_by_post_id($post_id);
if ( $Total_Likers_ids) //found likes in post
{
    //search function retrun int(0) if result is found else return false
    $found = array_search($myid,$Total_Likers_ids) ;
    if (  is_numeric($found) )//check if my id exist in list
    {   
        $love_content= "<i style='color:#ed4956;' class='fas fa-heart'></i>";   
    }    
}


//####################################################



//Get random liker data
$countlike = $likeobj->count_likes_by_post_id($post_id);
$random_liker = $likeobj->get_one_random_like_by_post_id($post_id);
if ( $random_liker)
{  
    $liker_id = $random_liker['user_id']; 
    $liker_name   = $random_liker['username'];
    $liker_avatar = $random_liker['user_avatar'];
    if ($liker_id == $myid)
        $liker_name = 'You';
}
//########################################################

// LOOP TO GET DATA OF EVERY ID IN LIKERS_LIST OF THIS POST

// foreach ($like_list as $one_liker_id) {  
//     $result = $userobj->get_user_by_id($one_liker_id); 
//     $liker_id = $one_liker_id; 
//     $liker_name   = $result[1];
//     $liker_avatar = $result[4];
//     echo "Liker Number : <br>ID:$liker_id  Name:$liker_name Avatar:$liker_avatar <br>";
    
// }

echo "
<div class='icons-section'>
<div >
    <a href='SomeActions/post_like.php?post_id=".$post_id."'>".$love_content."</a>
    <a href='#'><i class='far fa-comment'></i></a>
    <a href='#'><i class='far fa-paper-plane'></i></a>
 </div>
 
 <div class='bookmark-icon'>
    <a href='#'><i class='far fa-bookmark'></i></a>     
 </div>

</div>";

if ($countlike >0){
echo " <div class='liker-names-section'>
         <div class='liker-name-photo'>
         <img src='uploads/".$liker_avatar."'>
         </div>   
         
         <div class='liker-names-links'>
            <span>Liked by</span>
            <a href='otherprofile.php?id=".$liker_id."'>".$liker_name."</a> 
            <span> and </span>  
            <a href='#'> ".($countlike-1)." others</a> 
         </div>
</div>"; 
}
echo"
<div class='caption-section'>
       <a href='#'>".$username."</a> 
       <span>".$post_caption." </span>
</div>
<div class='display-partof-comments'>
";

 // GET COMMENT DATA FOR EACH POST
 $Comments_list = $commentobj->get_all_comments_by_post_id($post_id);
 $countComments = $commentobj->count_comments_by_post_id($post_id);
// echo"<pre>";
// print_r($Comments_list);
// exit();
// LOOP TO GET DATA OF EVERY ID IN COMMET_LIST OF THIS POST
if($Comments_list)
{
 foreach ($Comments_list as $one_Comment) {  

    $Commenter_id = $one_Comment['user_id']; 
    $Commenter_name = $one_Comment['username']; 
    $Commenter_avatar = $one_Comment['user_avatar']; 
    $Comment_id =   $one_Comment['comment_id']; 
    $Comment_txt =   $one_Comment['comment_txt']; 
    $Comment_date =   $one_Comment['comment_date']; 
   
  

                echo "
                
                <div class='single-comment'>
                        <a href='otherprofile.php?id=".$Commenter_id."'>".$Commenter_name."</a> 
                        <span>".$Comment_txt." </span>
                </div>";
 } }

echo "  </div>
<div class='time-section'>
    <span><a href='#'>$post_date </a></span>
</div>
<div class='add-comment-section'>

    <form  class='comment_form' method='get' action='SomeActions/post_comment.php'>
    <div class='commentbox'>
        <input type='hidden' value='".$post_id."' name='post_id'>
        <textarea name ='comment'placeholder='Add a comment...'></textarea>
    </div>
    <div class='commentbutton'>
        <button type='submit'>Post</button>
    </div>
    </form>

    </div>

    </div>
  </section> 
  </body>
</html>
";

    } 

}








