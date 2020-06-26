<?php

//  if the user not logged in and remember me cookie exists :
      if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){ // (!) missing.
      
            //  extract authenitificators 1 and 2 from the cookie:
                  // f1:  $a1 . "," . bin2hex($a2);
                  // f2:  hash("sha256", $a);
            //  extract authenitificators 1 and 2 from the cookie 
              list($authentificator1,$authentificator2) = explode(',', $_COOKIE['rememberme']);
              $authentificator2 = hex2bin($authentificator2);
              $f2authentificator2 = hash('sha256', $authentificator2);
    
            // look for authenitificator 1 in the remember me table 
             $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1' ";
             $result = mysqli_query($connect,$sql);
               if(!$result){
                  echo '<div class="alert alert-danger">There wan an error, Running the query.</div>';
                  echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
                    exit;
               }
               $count = mysqli_num_rows($result);
                 if($count !== 1){
                  echo '<div class="alert alert-danger">Remember me process failed!</div>';
                   exit;
                 }

                 $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                 // if authenitificator 2 does not match 
                   if(!hash_equals($row['f2authentificator2'] , $f2authentificator2)){
                        //  print error 
                        echo '<div class="alert alert-danger">hash_equals returned false!</div>';
                 
                   }else{
                        //   Generate new authenitificators
                        //   Store them in cookie and remember me table 
                              
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
            $sql = " INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expires)
             VALUES ('$authentificator1','$f2authentificator2', '$user_id', '$expiration')";
          //    Run the query:
            $result = mysqli_query($connect,$sql);
             if(!$result){
               //    error
               echo '<div class="alert alert-danger">There wan an error sorting the data to the database to remember you!</div>';
               echo '<div class="alert alert-danger"> ' . mysqli_error($connect).'</div>';
              exit;
              
             }
                        // log the user in and redirect to notes page
                        $_SESSION['user_id'] = $row['user_id'];
                        header('location:mainPageLoggedin.php');
                   }
      }


?>