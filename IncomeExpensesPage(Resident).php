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
    <title>Income/Expenses Page</title>
</head>
<body>
    <h1>Incomes/Expenses</h1>
    <hr>
    <!-- Navbar to go between pages for resident. -->
    <?php include 'navbarResident.php';?>
    <div id="box">
    <?php
    //Selecting the ones who paid their dues.
    $sql_income = "SELECT * FROM dues_table WHERE status='paid' ORDER BY date DESC";
    $result_income = mysqli_query($connection, $sql_income);

    //Selecting expense information from table.
    $sql_expense = "SELECT * FROM expenses_table ORDER BY date DESC";
    $result_expenses = mysqli_query($connection, $sql_expense);

    ?>
    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#incomeList">Income Table</button>
    <div id="incomeList" class="collapse" style="max-width:900px;">
    <?php
    
    //Table to put the income result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Owner</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
    </tr>";
    
    //Writing the income values.
    if (mysqli_num_rows($result_income) > 0) {

       while($row = mysqli_fetch_assoc($result_income)) {
        echo "<tr>";   
        echo "<td>" . $row["owner"]. "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["status"]. "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "</tr>";
       }
    }
    echo "</table>";

    ?>
   </div>
   </div>

    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#expenseList">Expense Table</button>
    <div id="expenseList" class="collapse" style="max-width:900px;">
    <?php

    //Table to put the expense result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Description</th>
    <th>Amount</th>
    <th>Date</th>
    </tr>";
    
    //Writing the expense values.
    if (mysqli_num_rows($result_expenses) > 0) {

       while($row = mysqli_fetch_assoc($result_expenses)) {
        echo "<tr>";   
        echo "<td>" . $row["description"]. "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "</tr>";
       }
    }
    echo "</table>";

    ?>
   </div>
   </div>
   <?php
   
    //Closing connection.
    mysqli_close($connection);
    ?>       
    </div>
</body>
</html>