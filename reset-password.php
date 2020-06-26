
<!-- // This file receives the user_id and key genetrated to create new password.
// This file displays a form to input new password -->

<?php

//  The user is re-directed to this file after clicking the reset password link -->
// <!-- reset password link contains two Get parameters: user_id and  key:
 session_start();
 include('connection.php');

  ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Password Reset</title>
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
            <h1>Reset Password</h1>

            <!-- Reset password message from store-reset-password.php file -->
            <div id="resultMessage"></div>

<?php

//  // if user_id and  key is missing 
  if( !isset($_GET["user_id"]) || !isset($_GET["key"])){
       // print an error message
    echo '<div class="alert alert-danger">There wan an error, Please Click on the Reset password link you received by email</div>';
    exit;
   }
// <!-- else -->
//  Store them in two variables:
 $user_id = $_GET["user_id"];
 $key  = $_GET["key"];
 $time = time() - 86400;
//  prepare variables for the query:
  $user_id = msqli_real_escape_string($connect,$email);
  $key = msqli_real_escape_string($connect,$email);
//  Run query: Check Combaination of user_id and key exist and less than 24h old.
  $sql = " SELECT user_id FROM forgotpassword WHERE rkey ='$key' AND user_id ='$user_id' AND time > '$time' AND status ='pending' ";
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
       // else
      // Print reset password form with hidden user_id and key fields
      echo "
        <form method='post' id='resetPasswordForm'>
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='user_id' value='$user_id'>
           <div class='form-group'>
              <label for='password'>Enter your new password</label>
              <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
           </div>

           <div class='form-group'>
              <label for='password2'>Enter your new password</label>
              <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control'>
           </div>

           <input type='submit' name='resetPassword' id='resetPassword' value='Reset' class='btn btn-success btn-lg'>
        
        </form>
      
      ";

?>
           
        </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
<!-- 
       
      // Script for Ajax Call to store-reset-password.php which processes the data. -->
           <script>
           
           // Once the form is submitted:
 $("#resetPasswordForm").submit(function(e){
       // prevent default php processing
       e.preventDefault();
       //  Collect the user inputs
       let dataToPost = $(this).serializeArray();
    //    console.log(dataToPost);

      //  Send them to login.php using Ajax
      $.ajax({
            url: "store-reset-password.php",
            type: "POST",
            data: dataToPost,
            // Ajax Call successful: show success or error message
            success: function(data){
                  $("#resultMessage").html(data);
            },
             // Ajax Call fails: show Ajax Call error
            error: function(){
               $("#resultMessage").html("<div class'alert alert-danger'>There wan an error with the Ajax Call, Please try again later!</div>");
            }
      });

 });
                
           </script>



        </body>
</html>

