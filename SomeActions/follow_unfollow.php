
<?php

/**
 * if already following then it will unfollow and if not following then it will follow
 * @param $myid
 * @param $otherid
 * @return bool
 */
function Toggle_follow($myid,$otherid)
{   $userobj = new users();
    $obj_follow = new follow();
    $followingIDs_array = $userobj->get_following_by_id($myid);
    
// Note: A User Can Follow otheruser from Modal And To Redirect This User Correctly To Last Visted Profile,
// We Have To Get Referal URL And Extract From It Refral ID

$referal_url = $_SERVER["HTTP_REFERER"]; //get whole referal  url + parameters
 $url_components = parse_url($referal_url);  //Get array contain each component like scheme,host,path,query
 parse_str($url_components['query'], $params); //qurey contain string so  i will parse it into an assoc. array
$referal_id  = (int)$params['id']; //get id value as string so we converted it
if (!$referal_id)//  if empty then user was in myprofile page as it dont contain parameter
$referal_id = $myid;




    //search function retrun int(0) if result is found else return false 
    $found = array_search($otherid,$followingIDs_array) ;
    if (  is_numeric($found))//check if his id exist in my list then i will unfollow
    { 
        $obj_follow->unfollow_user($myid,$otherid); 
        
        header("Location:http://localhost/level1/New IG Version/otherprofile.php?id=$referal_id");
    }    

    else //his id not found in mylist ,So I will Follow
    {    

         $obj_follow->follow_user($myid,$otherid);
        header("Location:http://localhost/level1/New IG Version/otherprofile.php?id=$referal_id");

    }
    
    
}




// echo"<pre>";
// print_r($all_posts);
// exit();

include("../includes/System.php");

session_start();
checkLogin();

if( isset($_GET['id']) ) 
{

//logged in id
$myid = $_SESSION['user'][0]; 

//other profile id
$otherid = $_GET['id'];

 if ($myid !== $otherid)
 Toggle_follow($myid,$otherid);
 else 
 header("Location:http://localhost/level1/New IG Version/myprofile.php");



}