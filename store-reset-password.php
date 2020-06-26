<!-- // This file recieves : user_id, genetated key to reset password: password 1 and password 2
// This file then resets password for user_id, if all checks are correct -->
<?php
session_start();
include('connection.php');

// Defineing variables:
$error = "";

//if user_id or activation key is missing 
  if(!isset($_POST['user_id']) || !isset($_POST['key'])){
    // print an error message
     echo '<div class="alert alert-danger">There wan an error, Please Click on the Reset password link you received by email</div>';
    exit;
  }
  // else 
    // Store them in two variables
    // Define a time variable : now minus 24 hours
    $user_id = $_POST['user_id'];
    $key = $_POST['key'];
    $time = time() - 86400;
     // Prepare variables for the query
     $user_id = mysqli_real_escape_string($connect,$user_id);
     $key = mysqli_real_escape_string($connect,$key);
     
     //  Run query: Check Combaination of user_id and key exist and less than 24h old.
  $sql = " SELECT user_id FROM forgotpassword WHERE rkey ='$key' AND user_id ='$user_id' AND time > '$time' AND status = 'pending' ";
  $result = msqli_query($connect,$sql);

  if(!$result){
    echo "<div class='alert alert-danger'>There was an error Running the query.</div>";
    echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
    exit;
}
    // if Combaination does not exist
    //  Print an error message
    $count = mysqli_num_rows($result);
       if($count !== 1){
           echo "<div class='alert alert-danger'>Error, Please try again.</div>";
           exit;
       }

        //  else
         //  Define errors messages

  $missingPassword = '<p> <b>Please enter a password!</b> </</p>';
  $invalidPassword = '<p> <b>Password should be at leats 6 characters long and one Capital letter and one number!</b> </</p>';
  $diffrentPassword = "<p> <b>Password don't match !</b> </</p>";
  $missingPassword2 = '<p> <b>Please confirm your password</b> </</p>';

    //  Get user inputs: password 1 and password 2
    if(empty($_POST["password"])){
      $error .= $missingPassword;

}elseif( !(strlen($_POST["password"]) > 6 and preg_match('/[A-Z]/' , $_POST["password"]) and preg_match('/[0-9]/', $_POST["password"]))){
      $error .= $invalidPassword;
}else{
      $password = filter_var($_POST["password"] , FILTER_SANITIZE_STRING);
}
      if(empty($_POST["password2"])){
            $error .= $missingPassword2;            
      }else{
             $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
             if( $password !== $password2){
                  $error .= $diffrentPassword;
             }
      }
//   <!-- if there are any errors print error -->
     if($error){
           
            $resultMessage = "<div class='alert alert-danger'> . $error.</div>";
            echo $resultMessage;
            exit;
     }

     // else: No error:
          // Prepare variables for the query
          $password = mysqli_real_escape_string($connect, $password);
          $password = hash('sha256', $password);
          $user_id = mysqli_real_escape_string($connect,$user_id);

          // Update the user's password in the users table
          $sql = "UPDATE users SET password ='$password' WHERE user_id = '$user_id' ";
          $result = mysqli_query($connect,$sql);
            if(!$result){
              echo "<div class='alert alert-danger'>There was a problem storing the Password in the database,please try again later!</div>";
              exit;
            }

            // Set the key status to "used" in the forgotpassword table to prevent the key from being used.
            $sql = " UPDATE forgotpassword SET status = 'used' WHERE rkey = '$key' AND user_id = '$user_id' ";

            $result = mysqli_query($connect,$sql);
              if(!$result){
                // print error message
                echo "<div class='alert alert-danger'>Error: Running the query!</div>";
                
              }else{
                // print success message
                echo "<div class='alert alert-success'>Your Password has been updated successfully</div> " . "<br></br>";
                echo "<a href='index.php'>Log in?</a>";
                
              }
?>
