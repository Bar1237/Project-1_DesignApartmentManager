<?php
//Connecting to database.
include 'databaseConnection.php';
//Getting the due number.
$dueNumber = $_GET["due_number"];

$sqlPayDue = "UPDATE dues_table SET status='paid' WHERE due_number='$dueNumber'";
        
    if (mysqli_query($connection, $sqlPayDue)) {
        echo '<script language="javascript">';
        echo 'alert("Due is paid.")';
        echo '</script>';
    }else{
        echo '<script language="javascript">';
        echo 'alert("Error:Due can not paid!")';
        echo '</script>';
    }
      header('Location: IncomeExpensesPage(Manager).php');
?>     