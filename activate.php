<?php

//  The user is re-directed to this file after clicking the activation link -->
// <!-- Signup link contains two Get parameters: email and activation key:
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
            <h1>Account Activation</h1>

<?php

//  if email or activation key is missing show an error:
  if( !isset($_GET["email"]) || !isset($_GET["key"])){
    echo '<div class="alert alert-danger">There wan an error, Please Click on the activation link you received by email</div>';
    exit;
   }
// <!-- else -->
//  Store them in two variables:
 $email = $_GET["email"];
 $key = $_GET["key"];
//  prepare variables for the query:
  $email = msqli_real_scape_string($connect,$email);
  $key = msqli_real_scape_string($connect,$key);
//  Run query: set activation field to "activated" for the provided email:
  $sql = "UPDATE users SET activation ='activated' WHERE (email = '$email' AND activation = '$key') LIMIT = 1 ";
  $result = msqli_query($connect,$sql);
// if the query is successful : show success message and invite user to login:
   if(msqli_affected_rows($connect) == 1){
      // show success message
      echo '<div class="alert alert-success">Your Account has been activated.</div>';
      // invite user to login
      echo '<a href="index.php" type="button" class="btn-lg btn-success">Log in</a>';
     

   }else{
     //  show error message 
     echo '<div class="alert alert-success">Your Account could not be activated, Please try again later.</div>';
   }

?>
           
        </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </body>
</html>