<?php
//  start session
session_start();
// include the connection file
include('connection.php');

// Get the user_id
$user_id = $_SESSION['user_id'];
// Get the current time
$time = time();
// Run query to create a new note
 $sql = " INSERT INTO notes (`user_id`,`note`,`time`) VALUES ('$user_id' , '', '$time') ";
 $result = mysqli_query($connect,$sql);
   if(!$result){
     echo 'error';
   }else{
      // mysqli_insert_id($connect) : will returns the auto generated id used in the lase query
      echo mysqli_insert_id($connect);
   }


?>