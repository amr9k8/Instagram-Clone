<?php

require("includes/System.php");

$error = "";
$done = "";
session_start();
checkLogin();

if(isset($_POST['upload']))
{
    //get id
    $id    = $_SESSION['user'][0];

    //get data of photo
    $errors =   $_FILES['post']['error'];
    $post_title  =   $_FILES['post']['name'];
    $tmp    =   $_FILES['post']['tmp_name'];
    $size   =   $_FILES['post']['size'];
    $type   =   $_FILES['post']['type'];
    $caption=   $_POST['caption'];
    //GENRATING DIFFRENT NAMES OF IMAGES
    $post_title = md5(rand(1,5000)).'_'.$post_title;
    //CHECK
    if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg' ) 
        { 
        
        if ( move_uploaded_file($tmp,'uploads/'. $post_title) ) 
        {
            $postobj = new posts();
            if( $postobj->add_post($id,$post_title,$caption) )
            {
                $done=" <p style='color:green; font-size:16px;'>
                Data Uploaded successfully</p>";              
            }     
        }  

    }        
       
    
    else 
        $error = "<p style = 'color:red;font-size:15px'>please select file first</p>";  
        
}

include("templates/add_post.html");
