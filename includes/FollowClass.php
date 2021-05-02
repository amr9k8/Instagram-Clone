<?php

// require("config.php");

class follow
{
/*
    other id = id of other persons 
    myid = id of logged in person 
     * constructor start connection
     *  
     * follow and unfollow
     * 1)set_follower_for_other_id             [used to update value of other_person followers after pressing follow button]
     * 2)set_following_for_my_id               [used to update value of  logged_in_person following after pressing follow button]
     * 3)unset_follower_for_other_id           [used to update value of other_person followers after pressing unfollow button]
     * 4)unset_following_for_my_id             [used to update value of  logged_in_person following after pressing unfollow button]
     * 
     * 
     * destructor close connection
     */
     
     
//variables
 private $connection; 

 //functions
 
 // constructor
     public function __construct()
     {
        $this->connection = new mysqli(DBHOST, NAME,PASS,DBNAME);
     }

// 1)
     public function set_follower_for_other_id($myid,$otherid)
     {  

        if ( $myid &&  $otherid ) {
            
            $this->connection->query(" INSERT INTO `follower`
            ( `account_id`,`follower_id`) 
            VALUES ($otherid,$myid)   ");

            if($this->connection->affected_rows >0 )
                return true ;
        }
            return false ;
     }

// 2)
     public function set_following_for_my_id($myid,$otherid)
     {  

        if ( $myid &&  $otherid ) {
                
            $this->connection->query(" INSERT INTO `following`
            ( `account_id`,`following_id`) 
            VALUES ($myid,$otherid)   ");

            if($this->connection->affected_rows >0 )
                return 1 ;
        }
            return 0 ;
     }

// function 1) and  function 2)  
     public function follow_user($myid,$otherid)
     { 
        $x=$this->set_follower_for_other_id($myid,$otherid);//return true or false
        $y=$this->set_following_for_my_id($myid,$otherid);//return true or false
        if($x && $y) //both are true
        return true;
        return false;   //else return false
     }



// 5)
    public function remove_from_following($myid,$otherid)
     {  

        if ( $myid &&  $otherid ) {
                
            $this->connection->query(" DELETE  FROM `following` 
            WHERE`account_id`=$myid AND `following_id`= $otherid ");
            
            if($this->connection->affected_rows >0 )
                return 1 ;

        }   
            return 0 ;
     }

// 6) $otherid mean other person  
   public function remove_from_followers($myid,$otherid)
     {  
        if ( $myid &&  $otherid ) {
                
            $this->connection->query(" DELETE FROM `follower` 
            WHERE`account_id`=$otherid AND `follower_id`= $myid ");
            
            if($this->connection->affected_rows > 0 )
                return 1 ;
        }
            return 0 ;
     }

// function 5) and  function 6)  
     public function unfollow_user($myid,$otherid)
     { 
        $x=$this->remove_from_following($myid,$otherid);//return true or false
        $y=$this->remove_from_followers($myid,$otherid);//return true or false
        if($x && $y) //both are true
        return true;
        return false;   //else return false
     }




    
//destruct
    public function __destruct()
    {
    $this->connection->close();
    }



}

//testing

// $obj = new follow();

// // follower test

//     if ($obj->unfollow_user(9,8) )
//     echo "done";

// }
// else 
// {
//     echo "he is duplicated";
// }

//following test
// if ($obj->check_for_following_duplication(3,1) ) // check if otheruser isalready in  your  following_list or not
// {
//     // // user id 3  follow user id 1
//     if ($obj->set_following_for_my_id(3,1) )
//     echo "done";
// }
// else 
// {
//     echo "he is duplicated";
// }


