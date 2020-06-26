
 <?php
session_start();
  if(!isset($_SESSION['user_id'])){
     header('location: index.php');
  }

    // Run query to retrieve the username instead of retrieving it from the session:
    include('connection.php');
    //  Get the user_id
    $user_id = $_SESSION['user_id'];
    // Get the username and email from the database
    $sql = " SELECT * FROM users WHERE user_id = '$user_id' ";
    $result = mysqli_query($connect,$sql);
    $count = mysqli_num_rows($result);
      if($count == 1){
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $username = $row['username'];
          $email = $row['email'];
  
      }else{
          echo "There was an error retrieving the username and email from the database";
      }

?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Notes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styling.css">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      
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
                  <li class="active"><a href="#">My Notes</a></li>
                  <li ><a href="profile.php">Profile</a></li>
                  <li ><a href="#">About</a></li>
                  <li ><a href="#">Contact us</a></li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                 <li><a href="#">Logged in as <b><?php echo $username; ?></b></a></li>
                 <li><a href="index.php?logout=1">Log out</a></li>
               </ul>
            </div>
        </div>
     </nav>
     

     <!--Notes container -->
     <div id="container" class="container">
             <!-- Alert message -->
         <div id="alert" class="alert alert-danger collapse">
               <a class="colse pull-right" data-dismiss="alert" style="cursor:pointer">
                   &times;
                   </a>
               <p id="alertContent"></p>
         </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                  <div class="buttons">
                        <button type="button" id="addNote" class="btn btn-lg blueBtn">Add Note</button>
                        <button type="button" id="allNotes" class="btn btn-lg blueBtn">All Notes</button>
                        <button type="button" id="edit" class="btn btn-lg btn-danger pull-right">Edit</button>
                        <button type="button" id="done" class="btn btn-lg btn-info pull-right">Done</button>
                  </div>
                  <div id="notesPad">
                     <textarea rows="10" id="notePad">
                     
                     </textarea>
                     <div id="notes" class="notes">
                     
                        <!-- Ajax call to php file -->
                     </div>
                  </div>
            </div>
        </div>
     </div>

    

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
    <script src="myNotes.js"></script>
  </body>
</html>