<?php


//  require("config.php");
//  require("genral.function.php");
class posts
{
    /*
     * constructor start connection
     * 
     * 1)get_profile  ->   [for profiles]
     * 2)get_feed  
     * 3)add_post
     * 4)remove_post
     * 5)get_explore
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
//0 get all users id for explore page
     //0) get all followings_IDs
     public function get_All_IDs()
     {
         $result =  $this->connection->query("SELECT users.id as userid FROM `users`  ");
         if($result->num_rows >0)
             {   $all_IDs = array();
                 while( $row = $result->fetch_row()  )
                 { $all_IDs[] = $row; }
                 
                 $all_IDs =  organize_array($all_IDs);
                 return $all_IDs;
             }
     }

 //0) get all followings_IDs
    public function get_following_IDs($id)
    {
        $result =  $this->connection->query("CALL `get_following`($id)  ");
        if($result->num_rows >0)
            {   $followings = array();
                while( $row = $result->fetch_row()  )
                { $followings[] = $row; }
                
                $this->connection->next_result();
                $following_IDs =  organize_array($followings);
                return $following_IDs;
            }
            $this->connection->next_result();
            return 0;
            
    }
  
// 1)
    public function get_profile($user_id) //select all image of this user in descending order to show it in his profile
    {   
        
     $result = $this->connection->query(" CALL get_posts($user_id) " );
       if($result->num_rows >0)
       {
           $posts = array();
           while( $row = $result->fetch_row()  )
           {
               $posts[] = $row;
           }
           $this->connection->next_result(); //must use it due to calling stored proceduers
           return $posts; //post-id and title

       }

       $this->connection->next_result();
       return null ; 
    }

    public function count_posts($user_id) //select all image of this user in descending order to show it in his profile
    {   
    
        $result = $this->connection->query(" CALL count_posts($user_id) " );
        if ($result)
        {
            if($result->num_rows >0)
            {
                $countposts =  $result->fetch_row() ;
                
                $this->connection->next_result(); //must use it due to calling stored proceduers
                return $countposts[0]; //number of posts
            }
        }  
       $this->connection->next_result();
       return 0 ; 
    }
     
    /**
     * get all recent posts from following list + myaccount
     */
    public function get_feed_by_id($myid) 
    {  
    //1) get all followings_IDs
        $following_IDs =  $this->get_following_IDs($myid);
        if($following_IDs) //check if array is returned
        array_push($following_IDs,$myid);

        else // if null is returned then create array contain myid
        {
            $following_IDs = array();
            $following_IDs[0] = $myid;
        }
      
      
    if ($following_IDs)
    {    
         $users = array();
            foreach ($following_IDs as $oneID) {
                
        // this sql statment will get post_id ,post_title , uploader_name , uploader_avatar,uploader_id
            $result =  $this->connection->query("SELECT * FROM `user_post` WHERE `user_id`=$oneID ORDER BY `post_id` DESC");
            if($result->num_rows >0)
                {
                    while( $row = $result->fetch_assoc()  )
                    {$users[] = $row; }//all data of any post are saved in this array
                }
        }
        
        //sort assoc array in Descending order According to post_id
        $post_id_arr = array_column($users, 'post_id'); //return all values for coulmn post_id
        array_multisort($post_id_arr, SORT_DESC, $users);//sort according to post_id
        return $users;
    }
    return 0;
}


// 3)
    public function add_post($user_id,$title,$caption) 
    {
        if ( strlen($title)>0 )
        {
            $this->connection->query(  "INSERT INTO `post`(  `user_id`,`title`,`caption`)
            VALUES ($user_id,'$title','$caption' )  " );
            if ($this->connection->affected_rows > 0)
                return true;
        }
        return false;
    }



// 4)
    public function remove_post($post_id)
    {
        
        $this->connection->query("DELETE FROM `post` WHERE id = $post_id ");
        if ($this->connection->affected_rows > 0)
            echo "done;";
            return true;

        return false;
    }
    


    public function get_explore_by_id($id) 
    {  
        $following_IDs = $this->get_following_IDs($id);
        $all_IDs = $this->get_All_IDs();
        $myid[0] = $id;
    
        if ($following_IDs)//not empty
            $explore_IDs = array_diff($all_IDs,$following_IDs,$myid);// Explore_IDs = (total_IDS - Following_IDS - My-ID)   
        else 
            $explore_IDs = array_diff($all_IDs,$myid);// Explore_IDs = (total_IDS - My-ID) 
         
            
         $users_in_explore = array();
        
        foreach ($explore_IDs as $oneID)
        {
                
         // this sql statment will get post_id ,post_title , uploader_name , uploader_avatar,uploader_id
            $result =  $this->connection->query("SELECT * FROM `user_post` WHERE user_id=$oneID ");
        
                if($result && $result->num_rows >0)
                {
                    
                    while( $row = $result->fetch_assoc()  )
                    {$users_in_explore[] = $row; }//all data of any post are saved in this array
                   
                }
                
        }
       
        return $users_in_explore;
    }


//8)
    public function get_post_by_id($post_id)
    {
        $result =  $this->connection->query("SELECT * FROM `user_post` WHERE post_id=$post_id ");

        if($result->num_rows >0)
        { $Allcomments = array();
            while( $row = $result->fetch_assoc()  )
            {$Allcomments= $row; }
            return $Allcomments;
        }
        

        return 0;
    }

    



    
//destruct
    public function __destruct()
    {
    $this->connection->close();
    }
}

//testing
// $obj = new posts();
// $result=$obj->get_feed_by_id(47);
// echo "<pre>";
// print_r($result);
// $recent = array_column($result, 'post_id');
// $final =array_multisort($recent, SORT_DESC, $result);
// print_r($result);


// $post_ids = array();
// foreach ($result as $key => $row)
// {   
//     $post_ids[$key] = $row['post_id'];
// }
// print_r($post_ids);