
$(function(){

    //  Define variables
       let activeNote = 0;
       let editNote = false;
    // load notes on page load: Ajax Call to loadNotes.php file.
    $.ajax({
         url: "loadNotes.php",
         success: function(data){
             $("#notes").html(data);
             clickonNote();
             deleteNote();
         },
         error: function(){
            $("#alertContent").text("There was a error with the Ajax Call, Please try again later.");
            $("#alert").fadeIn();
         }

    });

    // add note : Ajax Call to createNotes.php file.
    $("#addNote").click(function(){
            $.ajax({

                url: "createNotes.php",
                success: function(data){
                    if(data == 'error'){
                        $("#alertContent").text("There was a problem sorting the new note to the database!,try again");
                        $("#alert").fadeIn();
                    }else{
                        // Update the activeNote to the id of the new note.
                          activeNote = data;
                        //   make the textarea blank
                        $("textarea").val("");

                        // show , hide elements
                        showHide(["#notePad","#allNotes"], ["#notes","#addNote","#edit","#done"]);
                        // $("textarea").show();
                        $("textarea").focus();
                        
                    }
                },
                error: function(){
                    $("#alertContent").text("There was a error with the Ajax Call, Please try again later.");
                    $("#alert").fadeIn();
                }
            });
    });

    // type note: Ajax Call to updateNotes.php file.
    $("textarea").keyup(function(){

         $.ajax({
                 url: "updateNotes.php",
                 type: "POST",
                //  ajax call to updateNotes.php file to update the the task of the activeNote
                data: {note: $("textarea").val(), id: activeNote },
                success: function(data){
                    if(data == 'error'){
                        $("textarea").text("There was an error updating the new note, Please try again later!");
                        $("alert").fadeIn();
                    }
                },
                error: function(){
                    $("#alertContent").text("There was an error with the Ajax Call, Please try again later.");
                    $("alert").fadeIn();
                }
         });
    });

    // Click on all notes button
    $("#allNotes").click(function(){

        $.ajax({
                url: "loadNotes.php",
                success: function(data){
                    $("#notes").html(data);
                    showHide(["#addNote","#edit","#notes"] ,["#allNotes","#notePad"]);
                    clickonNote();
                    deleteNote();
                },
                error: function(){
                    $("#alertContent").text("There was an error with the Ajax Call, Please try again later.");
                    $("alert").fadeIn();
                }

        });
    });

    // Click on done button after editing note: Go to edit mode -> (show delete buttons,...);
        //  click on done
        $("#done").click(function(){
                // switch to non editMode
                editNote = false;
                // expand the notes
                $(".noteHeader").removeClass("col-xs-7 col-sm-9");
                // show , hide elements
                showHide(["#edit"],[this,".delete"]);
        });


        $("#edit").click(function(){
            // switch to the editMode
            editNote = true;
            // Reduce the width of the note
            $(".noteHeader").addClass("col-xs-7 col-sm-9");
            // show , hide elements
            showHide(["#done", ".delete"],[this]);
        });

    // functions
        // Click on a note
        function clickonNote(){

            $(".noteHeader").click(function(){
                
                if(!editNote){
                    // update activeNote to the id of the note.
                    activeNote = $(this).attr("id");
                    // fill the textarea.
                    $("textarea").val($(this).find(".noteText").text());
    
                       // show , hide elements
                         showHide(["#notePad","#allNotes"], ["#notes","#addNote","#edit","#done"]);
                        // $("textarea").show();
                         $("textarea").focus();
                }
            });
        }
      
        // Click on delete
            function deleteNote(){
                $(".delete").click(function(){
                    let deleteBtn = $(this);

                    // send current note content with it's id through ajax call to the deleteNote.php file.
                    $.ajax({
                        url: 'deleteNotes.php',
                        type: "POST",
                       //  Send ajax call to deleteNote.php
                        data: {id:deleteBtn.next().attr("id")},
                       success: function(data){
                           if(data == 'error'){
                               $("textarea").text("There was an error deleting the note, Please try again later!");
                               $("alert").fadeIn();
                           }else{
                              //  Remove the containing div
                               deleteBtn.parent().parent().remove();
                           }
                       },
                       error: function(){
                           $("#alertContent").text("There was an error with the Ajax Call, Please try again later.");
                           $("alert").fadeIn();
                       }
                });

                });
            }


        // show hide function
         function showHide(array1, array2){
             for(i=0; i < array1.length; i++){
                 $(array1[i]).show();
             }
             for(i=0 ; i < array2.length; i++){
                 $(array2[i]).hide();
             }
         }
});