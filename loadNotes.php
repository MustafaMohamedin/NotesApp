<?php
//  start session
session_start();
// include the connection file
include('connection.php');

// declare variables
// $user_id = "";

// Get the user_id
  $user_id = $_SESSION['user_id'];
// Run query to delete empty notes
$sql = " DELETE FROM notes WHERE note = '' ";
 $result = mysqli_query($connect, $sql);
  //  check the query:
    if(!$result){
      echo "<div class='alert alert-warning'>There was an error retrieving the notes!</div>";
      exit;
    }
// Run query to look for notes corresponding to user_id
  $sql = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY time DESC ";
  $result = mysqli_query($connect,$sql);
// show notes or alert message

    $result = mysqli_query($connect,$sql);
       if($result){
            if(mysqli_num_rows($result) > 0 ){
                    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                          $note_id = $row['id'];
                          $note = $row['note'];
                          $time = $row['time'];
                          $time = date("F d, Y h:i:s A");

                        echo " <div class='note'>
                                  <div class='col-xs-5 col-sm-3'>
                                      <button class='btn-lg btn-danger delete' style='width:100%'>delete</button>
                                  </div>
                        <div class='noteHeader' id='$note_id'>
                               <div class='noteText'>$note</div>
                               <div class='noteTime'>$time</div>
                        
                        </div>
                        </div>";
                    }
            }else{
              echo "<div class='alert alert-warning'>You have not Created any note yet, Click on add note button to create one!</div>";
            }
       }else{
         echo "<div class='alert alert-danger'>An error eccured!<div>";
         echo mysqli_error($connect);
         exit;
       }


  ?>