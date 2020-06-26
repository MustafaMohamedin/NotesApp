<?php
//  Start session
session_start();
// connect to DB
include('connection.php');

// Declare variables
$error = "";

// Define errors messages:
$missingCurrentPassword = "<p><strong>Please enter your current password!</strong></p>";
$incorrectCurrentPassword = "<p><strong>Password entered is incorrect!</strong></p>";
$missingPassword = "<p><strong>Please enter a new password</strong></p>";
$invalidPassword = "<p><strong> Your Password should be at least6 characters long and include one capital letter and one number! </strong></p>";
$missingPassword2 = "<p><strong>Please Confirm your password</strong></p>";
$diffrentPassword = "<p><strong>Password don't match!</strong></p>";

// check for errors
  if(empty($_POST['currentpassword'])){
      $error .= $missingCurrentPassword;
  }else{
      $currentPassword = $_POST['currentpassword'];
      $currentPassword = filter_var($currentPassword,FILTER_SANITIZE_STRING);
      $currentPassword = mysqli_real_escape_string($connect,$currentPassword);
      $currentPassword = hash("sha256", $currentPassword);
      // Check if the given password is correct
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT password FROM users WHERE user_id = '$user_id' ";
      $result = mysqli_query($connect,$sql);
      $count = mysqli_num_rows($result);
        if($count !== 1){
            echo "<div class='alert alert-danger'> There was a problem running the query.</div>";
            echo mysqli_error();
        }else{
             $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
             if($currentPassword !== $row['password']){
                  $error .= $incorrectCurrentPassword;
             }
        }
  }

  if(empty($_POST["password"])){
    $error .= $missingPassword; 
}elseif(!(strlen($_POST["password"])>6
         and preg_match('/[A-Z]/',$_POST["password"])
         and preg_match('/[0-9]/',$_POST["password"])
        )
       ){
    $error .= $invalidPassword; 
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING); 
    if(empty($_POST["password2"])){
        $error .= $missingPassword2;
    }else{
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $error .= $diffrentPassword;
        }
    }
}

// if there's an error print error message
  if($error){
     $resultMessage = "<div class='alert alert-danger'> $error</div>";
     echo $resultMessage;
  }else{
      // prepare varible to query
     $password = mysqli_real_escape_string($connect,$password);
     $password = hash("sha256",$password);
     // Run query to update the password
     $sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id' ";
    //  Check the query
    $result = mysqli_query($connect,$sql);
      if(!$result){
          echo "<div class='alert alert-danger'>The Password could not be reset, Please try again later!</div>";
      }else{
         echo "<div class='alert alert-success'>Your Password has been updated successfully. !!</div>";
      }
  }



?>