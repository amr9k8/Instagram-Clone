<?php

// echo"<pre>";
// print_r($result);
// exit();
include("includes/System.php");
session_start(); // get data of logged in user
checkLogin();

if ( isset($_GET["query"]) && $_GET["query"] )
{
        $keyword = $_GET["query"];
        $userobj = new users();
        $allresult = $userobj->search_user($keyword);
        if($allresult)
     {   
        foreach ($allresult as $result) 
        {
        $id = $result[0];
        $name = $result[1];
        $email = $result[2];
        $avatar = $result[4];
        }
        echo json_encode($allresult);

    }
    
    
    else
    {
            
            echo ''; 
    }


    $_GET["query"] = 0;
}

else
{
        echo"NoResults";
}