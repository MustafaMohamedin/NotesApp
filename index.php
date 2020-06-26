<?php
  session_start();
// connect to Database
include('connection.php');
// logout
include('logout.php');
// include rememberme
include('rememberme.php');

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Notes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet"> 

  </head>
  <body>

     <!-- Navigation bar -->
     <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
               <a href="#" class="navbar-brand"> Online Notes</a>
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-Collapse">
                   <span class="sr-only"> Toggle Navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-Collapse">
               <ul class="nav navbar-nav">
                  <li class="active"><a href="#">Home</a></li>
                  <li ><a href="#">About</a></li>
                  <li ><a href="#">Contact us</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                 <li><a href="#loginModal" data-toggle="modal">Login</a></li>
               </ul>
            </div>
        </div>
     </nav>

     <!--   Jumbotron with sign up button-->
      <div class="jumbotron">
         <h1>Online Notes App </h1>
         <p>Easy to use , protecs all your notes</p>
         <p>Your Notes with you wherever you go!</p>
         <button type="button" class="btn btn-lg greenBtn signup" data-target="#signupModal" data-toggle="modal">Sign Up</button>
      </div>

     <!-- login form -->
     <form method="post" id="loginForm">
             <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                   <div class="modal-content">
                      <div class="modal-header">
                          <button class="close" data-dismiss="modal"> &times;</button>
                          <h4>Login</h4>
                      </div>
                      <div class="modal-body">
                          
                           <div class="form-group">
                              <!-- login message from php file -->
                              <div id="loginMessage"></div>

                              <label for="loginEmail" class="sr-only">Email:</label>
                              <input type="email" name="loginEmail" id="loginEmail" placeholder="Email" maxlength="30" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="loginPassword" class="sr-only">Password:</label>
                              <input type="password" name="loginPassword" id="loginPassword" placeholder="password" maxlength="30" class="form-control">
                           </div>

                           <div class="checkbox">
                              <label for="rememberme">
                                 <input type="checkbox" name="rememberme" id="rememberme">
                                   Remember me
                              </label>
                              <a class="pull-right" data-dismiss="modal" data-target="#forgotPasswordModal" data-toggle="modal" style="cursor: pointer">Forgot password?</a>
                           </div>       
                      </div>
                      <div class="modal-footer">
                         <input type="submit" name="login" value="Login" class="btn blueBtn">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                         <button type="button" class="btn greenBtn pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                      </div>
                   </div>
                </div>

             </div>
         </form>

     <!-- sign up form -->
         <form method="post" id="signupForm">
             <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                   <div class="modal-content">
                      <div class="modal-header">
                          <button class="close" data-dismiss="modal"> &times;</button>
                          <h4>Sign up to use the App it's free and only takes a few minutes !</h4>
                      </div>
                      <div class="modal-body">
                           <div class="form-group">
                              <!-- sign up message from php file -->
                              <div id="signupMessage"></div>

                              <label for="username" class="sr-only">Username:</label>
                              <input type="text" name="username" id="username" placeholder="User name" maxlength="30" class="form-control" >
                           </div>
                           <div class="form-group">
                              <label for="email" class="sr-only">Email:</label>
                              <input type="email" name="email" id="email" placeholder="Email address" maxlength="30" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="password" class="sr-only">Password:</label>
                              <input type="password" name="password" id="password" placeholder="password" maxlength="30" class="form-control">
                           </div>
                           <div class="form-group">
                              <label for="password2" class="sr-only">Confirm password:</label>
                              <input type="password" name="password2" id="password2" placeholder="Confirm password" maxlength="30" class="form-control">
                           </div>
                      </div>
                      <div class="modal-footer">
                         <input type="submit" name="signup" value="Sign Up" class="btn greenBtn">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                   </div>
                </div>

             </div>
         </form>

     <!-- forgot password form -->
     <form method="post" id="forgotPasswordForm">
             <div class="modal" id="forgotPasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                   <div class="modal-content">
                      <div class="modal-header">
                          <button class="close" data-dismiss="modal"> &times;</button>
                          <h4>Forgot your password,please enter your email</h4>
                      </div>
                      <div class="modal-body">
                          
                           <div class="form-group">
                              <!-- forgot password message from php file -->
                              <div id="forgotPasswordloginMessage"></div>

                              <label for="forgotEmail" class="sr-only">Email:</label>
                              <input type="email" name="forgotEmail" id="forgotEmail" placeholder="Email" maxlength="30" class="form-control">
                           </div>
                              
                      </div>
                      <div class="modal-footer">
                         <input type="submit" name="forgotPassword" id="forgotPassword" value="Submit" class="greenBtn btn">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                         <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                      </div>
                   </div>
                </div>

             </div>
         </form>

     <!-- footer -->
     <footer class="footer">
        <div class="container">
           <p>Mustafa Mohamedin CopyRight, &copy; <?php $today = date("Y"); echo "$today"; ?> All Rights Reserved.</p>
        </div>
     </footer>

    <!-- jQuery necessary for Bootstrap's JavaScript plugins -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins below, or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="index.js"></script>
  </body>
</html>