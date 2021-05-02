<?php

/**
 * check if user logged in or not
 * @return bool
 */
function checkLogin()
{
    if (   ! isset($_SESSION['user']) )
        {   
            //used http//localhost to Allow Funtion Work IN Any Directory
              header("Location:http://localhost/level1/New IG Version/login.php");
        }
}

/**
 * make sure that user not logged in before visit registeration page
 */
function have_session_check()
{
    if (  isset($_SESSION['user']) )
        header("location:index.php");
}


/**
 * organize array
 */
function organize_array($array)
{
    $newarr = array();
    foreach ($array as $value) 
    {
        $newarr[] = $value[0];
    
    }
    return $newarr;
}

/**
 * check if following already or not
 * @param $myid
 * @param $otherid
 * @return bool
 * 
 */
function check_follow($myid,$otherid)
{   $userobj = new users();
    $followingIDs_array = $userobj->get_following_by_id($myid);
    if ($followingIDs_array) 
  {  //search function retrun int(0) if result is found else return false 
    $found = array_search($otherid,$followingIDs_array) ;
    if (  is_numeric($found) )//check if ha
    return 1;
   }
      //his id not found in mylist ,So I will Follow
    return 0;   
}


// $result = organize_array($x);
// echo "<hr> <br> <pre>";
// print_r($result);