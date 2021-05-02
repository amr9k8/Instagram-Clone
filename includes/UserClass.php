<?php

//  require("config.php");
//  require("genral.function.php");

class users
{
    /*
     * constructor start connection
     * 
     * 1)get_all_user ->     [for admin or Explore ]
     * 2)search()     ->     [name or email]
     * 3)get_user_by_id ->   [for profile]
     * 4)login_user
     * 5)register_user
     * 6)update functions -> [update_user_name(),update_user_pass(),update_user_email(),update_user_avatar()]
     * 7)get_followers_by_id [return follower's ids of specfic user  ]
     * 8)get_following_by_id  [return following's ids of specfic user  ]
     * 9)count_followers  [return number of followers ]
     * 10)count_following [return number of following ]
     * 
     * 11)suggestion_list ->[Get All Following List of Each Friends in your Following list and select 10 randomly  ]
     * destructor close connection
     */

     
//variables
 private $connection; 

//functions

// 0)
    public function __construct()
    {
       $this->connection = new mysqli(DBHOST, NAME,PASS,DBNAME);
    }

// 1)
    public function get_all_users($q="")
    {   
        
     $result = $this->connection->query("SELECT * FROM `users` $q");

       if($result->num_rows >0)
       {
           $users = array();
           while( $row = $result->fetch_row()  )
           {
               $users[] = $row;
           }
           return $users;
       }

       return null ; 
    }


// 2)
    public function get_user_by_id($id)
    {
        $result = $this->get_all_users(" WHERE id = '$id' ");
        if ($result)
        {
        return $result[0];
        }
        return null;
    }

// 3)
    public function search_user($keyword)
    {
        
        $result = $this->get_all_users(" WHERE name ='$keyword' OR email = '$keyword' OR name LIKE '%$keyword' OR name LIKE '$keyword%' ");
        return $result;
    }


// 4)
    public function login($username,$password)
    {
        $result = $this->get_all_users(" WHERE name ='$username' AND password = '$password'  ");
        if ($result)
        return $result[0];

        return 0;
    }


// 5)
    public function register_user ($username,$email,$password)
    {
        if ( strlen($username) > 0 && strlen($email) > 0 && strlen($password) > 0 )
        {      
                $this->connection->query(" INSERT INTO `users`
                ( `name`,`email`,`password`) 
                VALUES 
                ('$username','$email','$password')   ");

                if($this->connection->affected_rows >0 )
                    return true ;
        }

            return false ;
    }
    

// genral update function
    public function update_user_general ($id,$extra="")
    {
        $this->connection->query(" UPDATE `users`
         SET $extra WHERE id = $id  ");

        if($this->connection->affected_rows > 0 )
            return true ;
            return false ;
    }


// 6)

//________________________________________________________________________    
        public function update_user_name ($id,$username)
        {
            $this->update_user_general($id," `name`= '$username' ");
        }
//________________________________________________________________________  
       public function update_user_pass ($id,$password)
       {
           $this->update_user_general($id," `password`= '$password' ");
       }     
//________________________________________________________________________  
        public function update_user_email ($id,$email)
        {
            $this->update_user_general($id," `email`= '$email' ");
        }    
//________________________________________________________________________  
        public function update_user_avatar ($id,$avatar)
        {
            $this->update_user_general($id," `avatar`= '$avatar' ");
        }    
//________________________________________________________________________                 
            
        public function update_all_data ($id,$username,$email,$password,$avatar)
        {
            if (strlen($username) > 0 )
            $this->update_user_name($id,$username);
            
            if (strlen($email) > 0 )
            $this->update_user_email($id,$email);

            if (strlen($password) > 0 )
            $this->update_user_pass($id,$password);

            if (strlen($avatar) > 0 )
            $this->update_user_avatar($id,$avatar);
        }           
//________________________________________________________________________       



// 7)
public function get_followers_by_id($id)
{
        $result =  $this->connection->query("CALL `get_followers`($id)  ");
                    
            if($result->num_rows >0)
            {  
                $followers = array();
                while( $row = $result->fetch_row()  )
                    {
                        $followers[] = $row; 
                    }
                $this->connection->next_result();
                return organize_array($followers) ;
                
            }
        else 
        $this->connection->next_result();
            return 0;  
         
}


// 8)
    public function get_following_by_id($id)
    {
            $result =  $this->connection->query("CALL `get_following`($id)  ");
            if($result->num_rows >0)
                {   $followings = array();
                    while( $row = $result->fetch_row()  )
                    { $followings[] = $row; }
                    
                    $this->connection->next_result();
                    return organize_array($followings);
                }
            else 
            $this->connection->next_result();
                return 0;  
    }

 
// 9)
    public function count_followers($id)
    {
         $result1 =  $this->connection->query("CALL countfollowers($id)  ");
         if($result1->num_rows >0)
            {    
               $followersNumber = $result1->fetch_row()  ;

               $this->connection->next_result();
               return $followersNumber[0];
            }
            $this->connection->next_result();
             return 0;
    }

// 10)
    public function count_following($id)
    {
        $result2 =  $this->connection->query("CALL count_following($id)  ");
        if($result2->num_rows >0)
        {    
            $followingNumber = $result2->fetch_row()  ;

            $this->connection->next_result();
            return $followingNumber[0];
        }        

        $this->connection->next_result();
        return 0;     
    }

    
//11
    public function suggestion_list($id)
    {
    $allfriends =   $this->get_following_by_id($id);
if($allfriends)
{
    $bigarray = array($id); //an array to contain  followings list of every friend
    foreach ($allfriends as $friend) //contain id  of friend  (following list of profile)
    { 
        $mutualfriends_per_id = $this->get_following_by_id($friend);
        if($mutualfriends_per_id)
        $bigarray = array_merge($bigarray,$mutualfriends_per_id);
    }

    //remove any user in my following list
    $bigarray = array_diff($bigarray,$allfriends);

    //remove my id from suggestion list
    $myid[0]=$id; //array_diff take array param only so i put id in an array
    $bigarray = array_diff($bigarray,$myid);

    //remove any repeating
    $bigarray = array_unique($bigarray);

    // check if number of suggested people more than 5 then pick 5 randomly else return them all

    if (count($bigarray) > 5 )
        return array_rand($bigarray,5);

    return $bigarray;
  }
  return 0;

}




//destruct
    public function __destruct()
    {
    $this->connection->close();
    }


}

// testing
//  $obj = new users();
// $result=$obj->suggestion_list(52);
// // $result=$obj->get_following_by_id(4);
// echo "<pre>";
// print_r($result);

// $id = array(1,2,3,4,5);
// $res1=$obj->get_followers_by_id(2);
// $res2=$obj->get_following_by_id(2);
// echo "followers : <pre>";
// print_r($res1);
// echo " followings: <pre>";
// print_r($res2);
