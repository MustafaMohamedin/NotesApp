<?php
//  start session
session_start();
// include the connection file
include('connection.php');

// Get the id of the note through Ajax Call
$id = $_POST['id'];
// Get the content of the note through Ajax Call
$noteContent = $_POST['note'];
// Get the time
$time = time();
// Run query to update the note
$sql = "UPDATE notes SET note = '$noteContent', time = '$time' WHERE id = '$id' ";
$result = mysqli_query($connect,$sql);
  if(!$result){
    echo 'error';
  }

?>