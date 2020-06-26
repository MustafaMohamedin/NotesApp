<?php
session_start();
include('connection.php');

//get the id of the note through Ajax
$note_id = $_POST['id'];
$user_id = $_SESSION['user_id'];
// run a query to delete the note
$sql = "DELETE FROM notes WHERE id = $note_id ";
$result = mysqli_query($connect, $sql);
if(!$result){
    echo 'error';   
}

?>
                                  <!-- fix : notes don't get deleted -->