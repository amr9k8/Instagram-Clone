<?php 
define('DS',DIRECTORY_SEPARATOR); // get dir seprator dyanmically which is "/" in windows  or "\" in linux
define('ROOT' , dirname(__DIR__));   // get root folder which is New IG Version

define('INCLUDES' , ROOT.DS.'includes');   // get includes folder 

define('CONFIG' , INCLUDES.DS.'config.php');   
define('USER' , INCLUDES.DS.'UserClass.php');   
define('FOLLOW' , INCLUDES.DS.'FollowClass.php');  
define('POST' , INCLUDES.DS.'PostClass.php'); 
define('LIKE' , INCLUDES.DS.'LikeClass.php'); 
define('COMMENT' , INCLUDES.DS.'CommentClass.php'); 
define('FUNCTIONS' , INCLUDES.DS.'genral.function.php'); 


require(CONFIG);
include(USER);
include(FOLLOW);
include(POST);
include(LIKE);
include(COMMENT);
include(FUNCTIONS);
