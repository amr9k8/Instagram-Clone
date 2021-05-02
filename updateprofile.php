<?php
include("includes/System.php");

$error = "";
$done = "";
session_start();
checkLogin();
if(isset($_POST['update']))
{

//get id of user    
    $id    = $_SESSION['user'][0];

//get data from update form 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];

    //get data of photo
    $errors =       $_FILES['avatar']['error'];
    $avatar_title = $_FILES['avatar']['name'];
    $tmp    =       $_FILES['avatar']['tmp_name'];
    $size   =       $_FILES['avatar']['size'];
    $type   =       $_FILES['avatar']['type'];

    //GENRATING DIFFRENT NAMES OF IMAGES 
     $avatar_title = md5(rand(1,5000)).'_'.$avatar_title;
    //CHECK
    if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg' ) 
        { 
        
        if ( move_uploaded_file($tmp,'uploads/'. $avatar_title) ) 
        {
            $obj = new users();
            $obj->update_all_data($id,$username,$email,$password,$avatar_title);
            
                $done=" <p style='color:green; font-size:13px; margin-top:25px;'>
                Data Updated successfully <br> Visit Your Profile now from  <a style='color:black' href='myprofile.php'>here </a>
                </p>";
        }

    }
}

include("templates/updateprofile.html");
