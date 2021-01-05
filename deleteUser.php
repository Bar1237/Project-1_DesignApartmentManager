<?php
//Connecting to database.
include 'databaseConnection.php';
//Getting the userID
$userID = $_GET["userID"];

//Current date is taken and put to the table as the move out date.
$moveOutDate= date("Y-m-d");
$sqlMoveOutDateAdd= "UPDATE users SET moveOutDate = '$moveOutDate' WHERE id='$userID'";
mysqli_query($connection, $sqlMoveOutDateAdd); 

//User is copied to the move out users table.
$sqlCopyUser= "INSERT INTO move_out_users SELECT * FROM users WHERE id='$userID'";
mysqli_query($connection, $sqlCopyUser);

//User is deleted from the original table.        
$sqlDeleteUser = "DELETE FROM users WHERE id='$userID'";
        
    if (mysqli_query($connection, $sqlDeleteUser)) {
        echo '<script language="javascript">';
        echo 'alert("User is deleted.")';
        echo '</script>';
    }else{
        echo '<script language="javascript">';
        echo 'alert("Error:User can not deleted!")';
        echo '</script>';
    }

     header('Location: ResidentListPage(Manager).php');
?>