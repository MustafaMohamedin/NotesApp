<?php

// Start session 
session_start();
// Connect to the Database
include('connection.php');

// Get the user_id
$id = $_SESSION['user_id'];
// Get username send through ajax call
$username = $_POST['username'];
// Run a query to update the username
$sql = " UPDATE users SET username = '$username' WHERE user_id = '$id' ";
$result = mysqli_query($connect,$sql);
  if(!$result){

    echo "<div class='alert alert-danger'>There was an error updating the new username in the database, Please try again later.</div>";
  }


?>