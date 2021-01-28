<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="GeneralStyleFile.css">
    <?php include 'databaseConnection.php';?>
    <title>Add Due</title>
</head>
<body style="margin-top:10px;">
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>
    <!--Form to take the values of the new due.-->
    <div id="box">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br>
        
        <label for="amountID" style="display:block; font-size:25px; margin:auto; text-align:center;">Due Amount</label>
        <input type="text" id="amountID" name="amount" style="display:block; margin:auto;"><br><br>

        <label for="dateID" style="display:block; font-size:25px; margin:auto; text-align:center;">Due Date</label>
        <input type="date" id="dateID" name="date" class="form-control" style="width:200px; display:block; margin:auto;"><br><br>
        
        <input type="submit" name="add_due_button" id="button1" value="Add New Due" style="width: 300px; height: 80px;">
        </form>
    </div>

<?php
//If the form is set then the each data taken from the form are taken to the test_input function and then assigned to the variables.
if(isset($_POST['add_due_button'])){
    $amount=test_input($_POST['amount']);

    $date=test_input($_POST['date']);
     
    //Checking if any of the variables is empty. If there are empty ones then the data is not stored to database and error message is given to user.
    if((empty($amount))or(empty($date))){
        echo '<script language="javascript">';
        echo 'alert("Please enter all the information.")';
        echo '</script>';
    //If all of the required data is entered then it is saved to database.
    }else{
    //Selecting all of the user information from table.
    $sql = "SELECT * FROM users WHERE isActive='true'";
    $result = mysqli_query($connection, $sql);
    
    //Using while loop to add due to all usernames and if the username is empty then due is not added.
    if (mysqli_num_rows($result) > 0) {
    
      while($row = mysqli_fetch_assoc($result)) {
      $tempUserName= $row["userName"];
      $tempUserId= $row["id"];
    
        if(!(empty($tempUserName))){
          $sqlAddDue = "INSERT INTO `dues_table` (owner_id, amount, status, date, owner)
          VALUES ('$tempUserId', '$amount', 'not paid', '$date', '$tempUserName')";
          mysqli_query($connection, $sqlAddDue);
        } 
      }
    }
    
    header('Location: IncomeExpensesPage(Manager).php');
    }
    //Closing the connection.
    mysqli_close($connection);
}
//Function to check the data.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>  
</body>
</html>    