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
    <title>Add Expense</title>
</head>
<body style="margin-top:10px;">
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>
    <!--Form to take the values of the new expense.-->
    <div id="box">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br>
        
        <label for="expenseDescriptionID" style="display:block; font-size:25px; margin:auto; text-align:center;">Expense Description</label>
        <input type="text" id="expenseDescriptionID" name="expenseDescription" style="display:block; margin:auto;"><br><br>
        
        <label for="amountID" style="display:block; font-size:25px; margin:auto; text-align:center;">Expense Amount</label>
        <input type="text" id="amountID" name="amount" style="display:block; margin:auto;"><br><br>

        <label for="dateID" style="display:block; font-size:25px; margin:auto; text-align:center;">Expense Date</label>
        <input type="date" id="dateID" name="date" class="form-control" style="width:200px; display:block; margin:auto;"><br><br>
        
        <input type="submit" name="add_expense_button" id="button1" value="Add New Expense" style="width: 300px; height: 80px;">
        </form>
    </div>

<?php
//If the form is set then the each data taken from the form are taken to the test_input function and then assigned to the variables.
if(isset($_POST['add_expense_button'])){
    $description=test_input($_POST['expenseDescription']);

    $amount=test_input($_POST['amount']);

    $date=test_input($_POST['date']);
      
    //Checking if any of the variables is empty. If there are empty ones then the data is not stored to database and error message is given to user.
    if((empty($description))or(empty($amount))or(empty($date))){
        echo '<script language="javascript">';
        echo 'alert("Please enter all the information.")';
        echo '</script>';
    //If all of the required data is entered then it is saved to database.
    }else{
    $sqlAddExpense = "INSERT INTO `expenses_table` (description, amount, date)
    VALUES ('$description', '$amount', '$date')";
    
    if (mysqli_query($connection, $sqlAddExpense)) {
        echo '<script language="javascript">';
        echo 'alert("New Expense Added")';
        echo '</script>';
        header('Location: IncomeExpensesPage(Manager).php');
      } else {
        echo '<script language="javascript">';
        echo 'alert("Error:Can not add new expense!")';
        echo '</script>';
      }
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