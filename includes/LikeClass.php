<?php

//  require("config.php");
//  require("genral.function.php");
class Like
{
    /*
     * constructor start connection
     * 
     * 0)count_likes_by_post_id  
     * 1)get_likes_by_post_id  
     * 2)add_like_by_post_id 
     * 3)delete_like_by_post_id     
     *4) Get Random Person Data From Like List
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
//0 Like Counter for Post
     public function  count_likes_by_post_id($id)
     {
         $result =  $this->connection->query("CALL count_likes($id)");
         if($result)
         {
            if($result->num_rows >0)
                { 
                    $total_likes = $result->fetch_row();
                    $this->connection->next_result();
                    return $total_likes[0];
                }
         }
          $this->connection->next_result();
           return 0;
     }

//1) Add Like for Post
     public function  Add_like_by_post_id($user_id,$post_id)
     {
         $this->connection->query("INSERT INTO `likes`(`user_id`, `post_id`) 
         VALUES ($user_id,$post_id)");
         
         if($this->connection->affected_rows >0)
         {
            return 1;
         }
         

             return 0;
     }

//2) remove Like for Post 
        /**
         * by amr
         * @param int userid
         * @param int postid
         */
     public function  remove_like_by_post_id($user_id,$post_id)
     {
         $this->connection->query(" DELETE FROM `likes` WHERE `user_id` = $user_id AND `post_id`= $post_id");
         
         if($this->connection->affected_rows >0)
         {
            return 1;
         }
         

             return 0;
     }


     //3) select all Likes for Post 
        /**
         * by amr
         * @param int postid
         */
        public function  get_all_likes_by_post_id($post_id)
        {
           $result = $this->connection->query(" CALL get_likes($post_id)");
            if ($result)
            {
            if($result->num_rows >0)
            {
                $likers_list = array();
                while ($row = $result->fetch_row())
                {
                    $likers_list[] = $row ;
                }
               $this->connection->next_result();
               return organize_array($likers_list);
            }
        }
            $this->connection->next_result();
            return 0;
        }
   
//4) Get Random Person Data From Like List
        /**
         * by amr
         * @param int postid
         * @return random user,avtar,user_id
         */
public function  get_one_random_like_by_post_id($post_id)
{
   $result =$this->get_all_likes_by_post_id($post_id); // all likers ids
   if($result)
   {
        $rand_id =array_rand($result,1); //random index 
        $rand_id = $result[$rand_id]; //random id
        $result = $this->connection->query(" CALL get_random_like($post_id,$rand_id)");
        if ($result->num_rows >0)
        {  
            $user_data = array() ;
            while($row = $result->fetch_assoc())
            {
                $user_data = $row;
            }
            $this->connection->next_result();
            return $user_data;
        }
    }   
    $this->connection->next_result();
    return 0;
}

//destruct
    public function __destruct()
    {
    $this->connection->close();
    }
}

//testing
// $obj = new Like();
// $result=$obj->get_one_random_like_by_post_id(35);
// echo "<pre>";
// print_r($result);
