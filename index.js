// Ajax Call for the Sign up form.
// Once the form is submitted:
$("#signupForm").submit(function(e){
      // prevent default php processing
      e.preventDefault();
      //  Collect the user inputs
       let dataToPost = $(this).serializeArray();
      //  console.log(dataToPost);

       // Send them to signup.php using Ajax
         $.ajax({
               url: "signup.php",
               type: "POST",
               data: dataToPost,
               // Ajax Call successful: show success or error message
               success: function(data){
                  $("#signupMessage").html(data);
               },
                  // Ajax Call fails: show Ajax Call error
               error: function(){
                  $("#signupMessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call, Please try again later</div>");
               }
         });
         
});
      

// Ajax Call for the login form
// Once the form is submitted:
$("#loginForm").submit(function(e){
       // prevent default php processing
        e.preventDefault();
        // Collect the user inputs
        let dataToPost = $(this).serializeArray();
      //   console.log(dataToPost);

       // Send them to login.php using Ajax
        $.ajax({
              url: "login.php",
              type: "POST",
              data: dataToPost,
              // Ajax Call successful:
              success: function(data){
                // if login.php returns "success": redirect user to notes page
                if(data == "success"){
                      window.location = "mainPageLoggedin.php";
                }else{
                  // Otherwise show an error message
                  $("#loginMessage").html(data);
                }
              },
               // Ajax Call fails: Show Ajax Call error
              error: function(){
                  $("#loginMessage").html("<div class'alert alert-danger'>There wan an error with the Ajax Call, Please try again later!</div>");
              }
        });
});
   


// Ajax Call for the forgot password form
// Once the form is submitted:
 $("#forgotPasswordForm").submit(function(e){
       // prevent default php processing
       e.preventDefault();
       //  Collect the user inputs
       let dataToPost = $(this).serializeArray();
       console.log(dataToPost);

      //  Send them to login.php using Ajax
      $.ajax({
            url: "forgot-password.php",
            type: "POST",
            data: dataToPost,
            // Ajax Call successful: show success or error message
            success: function(data){
                  $("#forgotPasswordloginMessage").html(data);
            },
             // Ajax Call fails: show Ajax Call error
            error: function(){
               $("#forgotPasswordloginMessage").html("<div class'alert alert-danger'>There wan an error with the Ajax Call, Please try again later!</div>");
            }
      });

 });

  