<?php
 
// Start session
session_start();
// connect to DB
include('connection.php');

// Get the user_id and new email through ajax call
 $user_id = $_SESSION['user_id'];
 $newEmail = $_POST['email'];

// Check if email is already exists in the database : if is exists print en error,
$sql = "SELECT * FROM users WHERE email = '$newEmail' ";
$result = mysqli_query($connect,$sql);
$count = mysqli_num_rows($result);
  if( $count > 0 ){
      echo "<div class='alert alert-danger'>There is already a user registred with that email , Please choose another one!</div>";
      exit;
  }


// Get the current email
  $sql = "SELECT * FROM users WHERE user_id = '$user_id' ";
  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);
     if($count !== 1){
       echo "<div class='alert alert-danger'> There was an error retrieving the email from the database!</div>";
     }else{
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $email = $row['email'];
     }

     // Create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

// insert  new activation code in the users table
$sql = "UPDATE users SET activation2 = '$activationKey' WHERE user_id = '$user_id' ";
$result = mysqli_query($connect,$sql);
 if(!$result){
      echo "<div class='alert alert-danger'>There was an error inserting the user details in the Database!, </div>";
      echo mysqli_error();

 }else{
   // Send email with link to activateNewEmail.php with current email and new email and activation code

        $message = "Please Click on this link to update  your email:\n\n";
        $message .= "http://localhost/NotesApp/activateNewEmail.php?email=" . urlencode($email) . "&newEmail=" . urldecode($newEmail) . "&key=$activationKey";
         if(mail($email,"Update Email:", $message,"From:" ."onlineNotes@gmail.com")){
                echo "<div class='alert alert-success'>An email has been send to $newEmail. Please Click on the link to update your email.</div>";
         
              }

 }

?>