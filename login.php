<?php

//  Start session :
session_start();
// Connect to the Database :
include("connection.php");

//  Check user inputs 
$email = "";
$password = "";
//    Define error messages :
$error = "";

$missingEmail = "<p><strong>Please enter your email address</strong></p>";
$missingPassword = "<p><strong>Please enter your password</strong></p>";
//  Get: email and password :
//  Store errors in error variable
    // Get Email:
 if(empty($_POST["loginEmail"])){
      $error .=$missingEmail;
 }else{
     $email = filter_var($_POST["loginEmail"] , FILTER_SANITIZE_EMAIL);
 }
     // Get password:
     if(empty($_POST["loginPassword"])){
          $error .=$missingPassword;
     }else{
          $password = filter_var($_POST["loginPassword"], FILTER_SANITIZE_STRING);
     }

//   if there are any errors :
     if($error){
          //  print error message :
          $resultMessage = "<div class='alert alert-danger'> .$error.</div>";
          echo $resultMessage;
     }else{

//   else: No errors
//       prepare variables for the query:
              $email = mysqli_real_escape_string($connect, $email);
              $password = mysqli_real_escape_string($connect, $password);
              // hashing the password: 256 bits -> 64 characters.
              $password = hash('sha256', $password);

//  Run query: Check combaination of email and password exists :
// $sql = "SELECT * FROM users WHERE email = '$email' AND password ='$password' AND activation = 'activated' ";

// Testing without activation key
$sql = "SELECT * FROM users WHERE email = '$email' AND password ='$password' ";
  $result = mysqli_query($connect,$sql);
  if(!$result){
     echo '<div class="alert alert-danger">Error: Running the query!</div>';
     echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
     exit;
 }
        
// if email and password don't match print error:
     $count = mysqli_num_rows($result);
      if($count !== 1){
          echo "<div class='alert alert-danger'>Wrong Username or Password, Try again!</div>";

      }else{
           // store the result of the query in a variable.
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          //  log the user in: Set session variables 
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['email'] = $row['email'];
          //  if remember me is not Checked :
               if(empty($_POST['rememberme'])){
                    //   print "Success" 
                    echo "success";
               }else{

          //  Create two variables : authentificator1 and authentificator2
             $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
             $authentificator2 = openssl_random_pseudo_bytes(20);

           //  Store them in a Cookie 
           function f1($a1,$a2){
               $c = $a1 . "," . bin2hex($a2);
               return $c;
           }
           $cookieValue = f1($authentificator1,$authentificator2);
            setcookie(
                 "rememberme",
                 $cookieValue,
                 time() + 10*24*60*60
            ); 
             function f2($a){
                  $b = hash("sha256", $a);
                  return $b;
             }
             $f2authentificator2 = f2($authentificator2);
             $user_id = $_SESSION["user_id"];
             $expiration = date("Y-m-d H:i:s", time() + 10*24*60*60);
            //   Run query: to store them in remember me table 
            $sql = "INSERT INTO rememberme ('authentificator1', 'f2authentificator2', 'user_id', 'expires')
             VALUES ('$authentificator1','$f2authentificator2', '$user_id', '$expiration') ";
          //    Run the query:
            $result = mysqli_query($connect,$sql);
             if(!$result){
               //    error
               echo '<div class="alert alert-danger">There wan an error sorting the data to the database to remember you!</div>';
               echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
              
             }else{
               //    success
               echo "success";
             }


           }
      }

     }
 




  ?>