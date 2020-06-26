<?php
// <!-- Start session -->
     session_start();
// <!-- Connect to the Database -->
   include('connection.php');
// <!-- Check user inputs -->
$username = "";
$email = "";
$password = "";
$error = "";
//        <!-- Define error messages --> 
  $missingUsername = '<p> <b>Please enter your name!</b> </p>';
  $missingEmail = '<p> <b>Please enter your email address!</b> </</p>';
  $invalidEmail = '<p> <b>Please enter a valid email address!</b> </</p>';
  $missingPassword = '<p> <b>Please enter a password!</b> </</p>';
  $invalidPassword = '<p> <b>Password should be at leats 6 characters long and one Capital letter and one number!</b> </</p>';
  $diffrentPassword = "<p> <b>Password don't match !</b> </</p>";
  $missingPassword2 = '<p> <b>Please confirm your password</b> </</p>';
//        <!-- Get username, email, password, password2 -->  

       //  Get Username:
         if(empty($_POST["username"])){
                $error .= $missingUsername;
         }else{
                $username = filter_var($_POST["username"] , FILTER_SANITIZE_STRING);
         }
       //   Get Email:
         if(empty($_POST["email"])){
                $error .= $missingEmail;
         }else{
                $email = filter_var($_POST["email"] , FILTER_SANITIZE_EMAIL);
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                       $error .= $invalidEmail;
                }
         }
       //   Get Passwords:
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
// <!-- No errors -->
       // prepare variables for the query:
              $username = mysqli_real_escape_string($connect, $username);
              $email = mysqli_real_escape_string($connect, $email);
              $password = mysqli_real_escape_string($connect, $password);
              // hashing the password: 128 bits -> 32 characters.
              // $password = md5($password);
              // hashing the password: 256 bits -> 64 characters.
              $password = hash('sha256', $password);

       // if the username exists in the user table print error :
              $sql = "SELECT * FROM users WHERE username = '$username' ";
              $result = mysqli_query($connect, $sql);
                if(!$result){
                    echo '<div class="alert alert-danger">Error: Running the query!</div>';
                    echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
                    exit;
                }
                $results = mysqli_num_rows($result);
                  if($results){
                  echo '<div class="alert alert-danger">That User name is already registered, Do you want to log in ?</div>';
                  exit;
                  }
                
       // if email exists in the user table print error -->
             $sql = "SELECT * FROM users WHERE email = '$email' ";
             $result = mysqli_query($connect, $sql);
               if(!$result){
                  echo '<div class="alert alert-danger">Error: Running the query!</div>';
                  echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
                  exit;
             }
             $results = mysqli_num_rows($result);
               if($results){
                  echo '<div class="alert alert-danger">That email is already registered, Do you want to log in ?</div>';
                  exit;
           }

//   <!-- else -->
        //  Create a unique activation code:
            // byte = 8 bit.
            //  bit = 0 or 1.
            //  16 bytes = 16*8 = 128 bits.
            // (2*2*2*2)*2*2*2*2*....2
            // 16*16*...16
            //  32 characters.
            $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
       //  <!-- Insert user details and activation code in the users table:
       //      $sql = "INSERT INTO users (`username` ,`email`, `password`, `activation`) VALUES ('$username','$email','$password','$activationKey')";
       //      Testing without activation key.
            $sql = "INSERT INTO users (`username` ,`email`, `password`) VALUES ('$username','$email','$password')";
             $result = mysqli_query($connect,$sql);
               if(!$result){
                      echo '<div class="alert alert-danger">There was an error inserting the user details into the database!</div>';
                      exit;
               }
            
      //  Send the user an email with a link to activate.php with their email and activation code:
       //  $message = "Please Click on this link to activate your Account:\n\n";
       //  $message .= "http://localhost/NotesApp/activate.php?email=" . urlencode($email) . "&key=$activationKey";
       //   if(mail($email,"Confirm you Registration", $message,"From:" ."onlineNotes@gmail.com")){
       //          echo "<div class='alert alert-success'>Thank for your Registration! a Confirmation email has been send to $email. Please Click on the activation link to activate your account.</div>";
         
              // }

      ?>