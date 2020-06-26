<?php

//  The user is re-directed to this file after clicking the email update activation link -->
// <!-- update email link contains three Get parameters: email and new email and activation key:
 session_start();
 include('connection.php');

  ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Account Activation</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            h1{
                color:purple;   
            }
            .contactForm{
                border:1px solid #7c73f6;
                margin-top: 50px;
                border-radius: 15px;
            }
        </style> 

    </head>
        <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Update Email</h1>

<?php

//  if email or newEmail or activation key is missing show an error:
  if( !isset($_GET["email"]) || !isset($_GET["newEmail"]) || !isset($_GET["key"])){
    echo '<div class="alert alert-danger">There wan an error, Please Click on the activation link you received by email</div>';
    exit;
   }
// <!-- else -->
//  Store them in two variables:
 $email = $_GET["email"];
 $newEmail = $_GET["newEmail"];
 $key = $_GET["key"];
//  prepare variables for the query:
  $email = msqli_real_scape_string($connect,$email);
  $newEmail = msqli_real_scape_string($connect,$newEmail);
  $key = msqli_real_scape_string($connect,$key);
//  Run query: update  the email to the new newEmail
  $sql = "UPDATE users SET email = '$newEmail' , activation2 ='0' WHERE (email = '$email' AND activation2 = '$key') LIMIT = 1 ";
  $result = msqli_query($connect,$sql);
// if the query is successful : show success message and invite user to login:
   if(msqli_affected_rows($connect) == 1){
      // destroy the session 
      session_destroy();
      // set the rememberme cookie to empty and expires to something in the past
      setcookie("rememberme", "", time() - 3600);
      // show success message
      echo '<div class="alert alert-success">Your email has been updated successfully!</div>';
      // invite user to login
      echo '<a href="index.php" type="button" class="btn-lg btn-success">Log in</a>';
     

   }else{
     //  show error message 
     echo '<div class="alert alert-success">Your email could not be updated !, Please try again later.</div>';
   }

?>
           
        </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </body>
</html>