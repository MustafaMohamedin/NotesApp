<?php

// Start session 
 session_start();
//  Connect to the Database
  include('connection.php');
//  Check user inputs 
$error = "";
$email = "";
//  Define error messages 
// Store errors in error variable
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
//   Get email 
   if(empty($_POST['forgotEmail'])){
         $error .= $missingEmail;
   }else{
         $email = filter_var($_POST['forgotEmail'], FILTER_SANITIZE_EMAIL);
          if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $error .= $invalidEmail;
          }
   }

// if there are any errors
  if($error){
        //   print error message 
        $resultMessage = "<div class='alert alert-danger'> .$error.</div>";
        echo $resultMessage;
        exit;
  }

//   else: No errors 
//      Prepare variables for the query 
     $email = mysqli_real_escape_string($connect,$email);

//   Run query : to Check if email exists in the users table 
   $sql = " SELECT * FROM users WHERE email = '$email' ";
     $result = mysqli_query($connect,$sql);
    
       if(!$result){
             echo "<div class='alert alert-danger'>There was an error Running the query.</div>";
             echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
             exit;
       }
       $count = mysqli_num_rows($result);
               //  if the email does not exists
               //   print error message 
         if($count !== 1){
               echo "<div class'alert alert-danger'>The email does not exist!</div>";
               exit;
         }

//    else -->
//       Get the user_id 
     $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
     $user_id = $row['user_id'];
//    Create a Unique activation code 
      $key = bin2hex(openssl_random_pseudo_bytes(16));
//    Insert user details and activation code in the forgotpassword table
      $time = time();
      $status = 'pending';
    $sql = " INSERT INTO forgotpassword (`user_id`, `rkey`, `time`, `status`) VALUES ('$user_id','$key','$time','$status') ";
     $result = mysqli_query($connect,$sql);
       if(!$result){
             echo "<div class='alert alert-danger'>There was an error inseting to the database, please try again later!</div>";
             echo '<div class="alert alert-danger">' . mysqli_error($connect).'</div>';
             exit;
       }    
  //  Send email with a link to reset-password.php with user_id and activation code 
    $message = "Please Click on this link to Reset Your password \n\n";
    $message .= "http://localhost/NotesApp/reset-password.php?user_id=$user_id&key=$key";
         //  if email send successfully
       if(mail($email,"Reset Your Password", $message,"From: " ."onlineNotes@gmail.com")){    
            //   print success message
            echo "<div class='alert alert-danger'>An email has been send to $email. Please Click on the link to Reset Your password. .<br>Thank You.</br> </div>";

       }

  ?>