<?php


//  require("config.php");
//  require("genral.function.php");
class Comment
{
    /*
     * constructor start connection
     * 
     * 0)count_commentss_by_post_id  
     * 1)get_comments_by_post_id  
     * 2)add_comment_by_post_id 
     * 3)delete_comment_by_post_id     
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
//0 comment Counter for Post
     public function  count_comments_by_post_id($id)
     {
         $result =  $this->connection->query("CALL count_comments($id)");
         if($result->num_rows >0)
             { 
                 $total_comments = $result->fetch_row();
                 $this->connection->next_result();
                 return $total_comments[0];
             }
             $this->connection->next_result();
             return 0;
     }

//1) Add comment for Post
     public function  Add_comment_by_post_id($txt,$user_id,$post_id)
     {
         $this->connection->query("INSERT INTO `comment`(`txt`,  `user_id`, `post_id`)
          VALUES ('$txt',$user_id,$post_id)");
         
         if($this->connection->affected_rows >0)
         {
            return 1;
         }
         
             return 0;
     }

//2) remove comment for Post 
        /**
         * by amr
         * @param int userid
         * @param int postid
         */
     public function  remove_comment_by_post_id($comment_id,$post_id)
     {
         $this->connection->query(" DELETE FROM `comment` WHERE `id` = $comment_id AND `post_id`= $post_id");
         if($this->connection->affected_rows >0)
         {
            return 1;
         }
             return 0;
     }


     //3) select all comments for Post 
        /**
         * by amr
         * @param int postid
         */
        public function  get_all_comments_by_post_id($post_id)
        {
           $result = $this->connection->query(" CALL get_comments($post_id)");
                
            if($result->num_rows >0)
            {
                $commentrs_list = array();
                while ($row = $result->fetch_assoc())
                {
                    $commentrs_list[] = $row ;
                }
               $this->connection->next_result();
               return $commentrs_list;
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
// $obj = new comment();
// $result=$obj->get_all_comments_by_post_id(3);
// echo "<pre>";
// print_r($result);
