<?php
  
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "onlineNotes");

$connect = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);

  if( mysqli_connect_error()){
    die(mysqli_connect_error());
  }
  
  // if($connect){
  //   echo "connection successfully!";
  // }else{
  //   echo "connection failed !";
  // }


?>