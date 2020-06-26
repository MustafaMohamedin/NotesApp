/* This file is responsible for the profile page.
 This file will send 3 ajax call ,  for : 1) update username 
                                          2) update password
                                          3) update email

 */             

//  Update username:

$("#updateusernameform").submit(function(e){
  // prevent default php processing
  e.preventDefault();
  //  Collect the user inputs
   let dataToPost = $(this).serializeArray();  
   // Send them to updateUsername.php using Ajax
     $.ajax({
           url: "updateUsername.php",
           type: "POST",
           data: dataToPost,
           // Ajax Call successful: show success or error message
           success: function(data){
              if(data){
                $("#updateusernamemessage").html(data);
                
              }else{
                location.reload();
              }
           },
              // Ajax Call fails: show Ajax Call error
           error: function(){
              $("#updateusernamemessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call, Please try again later</div>");
           }
     });
     
});
  

// Update password:

$("#updatepasswordform").submit(function(e){
  // prevent default php processing
  e.preventDefault();
  //  Collect the user inputs
   let dataToPost = $(this).serializeArray();  
   // Send them to updateUsername.php using Ajax
     $.ajax({
           url: "updatePassword.php",
           type: "POST",
           data: dataToPost,
           // Ajax Call successful: show success or error message
           success: function(data){
              if(data){
                $("#updatepasswordmessage").html(data);
                
              }
           },
              // Ajax Call fails: show Ajax Call error
           error: function(){
              $("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call, Please try again later</div>");
           }
     });
     
});

// Update email:

$("#updateemailform").submit(function(e){
   // prevent default php processing
   e.preventDefault();
   //  Collect the user inputs
    let dataToPost = $(this).serializeArray();  
    // Send them to updateEmail.php using Ajax
      $.ajax({
            url: "updateEmail.php",
            type: "POST",
            data: dataToPost,
            // Ajax Call successful: show success or error message
            success: function(data){
               if(data){
                 $("#updateemailmessage").html(data);
                 
               }
            },
               // Ajax Call fails: show Ajax Call error
            error: function(){
               $("#updateemailmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call, Please try again later</div>");
            }
      });
      
 });
 