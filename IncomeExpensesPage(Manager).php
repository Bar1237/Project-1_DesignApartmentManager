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
    <title>Incomes/Expenses Page</title>
</head>
<body>
    <h1>Incomes/Expenses</h1>
    <hr>
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>

    <div id="box">
    <?php
    //Getting the start date.
    if (isset($_POST['startingDate'])) {
      $startingDate = $_POST['startingDate'];
    }else{
      $startingDate = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1));
    }
    //Getting the end date.
    if (isset($_POST['endingDate'])) {
      $endingDate = $_POST['endingDate'];
    }else{
      $endingDate = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
    }
    //Selecting the sum of the paid dues between start and end date.
    $query = "SELECT SUM(amount) FROM dues_table WHERE status = 'paid' AND date BETWEEN '$startingDate' AND '$endingDate'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if($row['SUM(amount)'] > 0){
      $income = $row['SUM(amount)'];
    }else{
      $income=0;
    }
    //Selecting the sum of the not paid dues between start and end date.
    $query = "SELECT SUM(amount) FROM dues_table WHERE status = 'not paid' AND date BETWEEN '$startingDate' AND '$endingDate'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if($row['SUM(amount)'] > 0){
      $unpaiddues = $row['SUM(amount)'];
    }else{
      $unpaiddues=0;
    }
    //Selecting the sum of the expenses between start and end date.
    $query = "SELECT SUM(amount) FROM expenses_table WHERE date BETWEEN '$startingDate' AND '$endingDate'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if($row['SUM(amount)'] > 0){
      $expense = $row['SUM(amount)'];
    }else{
      $expense=0;
    }
    //Adjusting the chart with the selected values.
    echo "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    
    <script type='text/javascript'>
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      ['Due Income'," . $income . "],
      ['Expenses'," . $expense . "],
      ['Unpaid Dues'," . $unpaiddues . "]
    ]);
    
      // Optional; add a title and set the width and height of the chart
      var options = {'title':'Income/Expense Chart', 'width':850, 'height':400};
    
      // Display the chart inside the <div> element with id='piechart'
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
    </script>";
    ?>

    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#chart">Chart</button>
    <div id="chart" class="collapse" style="max-width:900px;">
    <!-- Writing the chart. -->
    <div id='piechart'></div>
    <!-- Getting start and end date from the user. -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

      <label for="startingDate">Starting Date:</label>
      <input type="date" id="startingDate" name="startingDate" class="form-control" value="<?php echo $startingDate; ?>">
        
      <label for="endingDate">Ending Date:</label>
      <input type="date" id="endingDate" name="endingDate" class="form-control" value="<?php echo $endingDate; ?>">
        
      <input type="submit" id="button1" value=Show style="width:200px;">
      
    </form>
    </div>
    </div>

    <?php
    //Selecting the ones who paid their dues with date.
    $sql_income_date = "SELECT * FROM dues_table WHERE status='paid' AND date BETWEEN '$startingDate' AND '$endingDate' ORDER BY date DESC";
    $result_income_date = mysqli_query($connection, $sql_income_date);

    //Selecting the ones who did not paid their dues with date.
    $sql_debt_date = "SELECT * FROM dues_table WHERE status='not paid' AND date BETWEEN '$startingDate' AND '$endingDate' ORDER BY date DESC";
    $result_debt_date = mysqli_query($connection, $sql_debt_date);

    //Selecting expense information from table with date.
    $sql_expense_date = "SELECT * FROM expenses_table WHERE date BETWEEN '$startingDate' AND '$endingDate' ORDER BY date DESC";
    $result_expenses_date = mysqli_query($connection, $sql_expense_date);

    //Selecting the ones who paid their dues.
    $sql_income = "SELECT * FROM dues_table WHERE status='paid' ORDER BY date DESC";
    $result_income = mysqli_query($connection, $sql_income);

    //Selecting the ones who did not paid their dues.
    $sql_debt = "SELECT * FROM dues_table WHERE status='not paid' ORDER BY date DESC";
    $result_debt = mysqli_query($connection, $sql_debt);

    //Selecting expense information from table.
    $sql_expense = "SELECT * FROM expenses_table ORDER BY date DESC";
    $result_expenses = mysqli_query($connection, $sql_expense);
    ?>
    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#incomeListDate">Selected Income Table</button>
    <div id="incomeListDate" class="collapse" style="max-width:900px;">
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
    if (mysqli_num_rows($result_income_date) > 0) {

       while($row = mysqli_fetch_assoc($result_income_date)) {
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
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#expenseListDate">Selected Expense Table</button>
    <div id="expenseListDate" class="collapse" style="max-width:900px;">
    <?php
    
    //Table to put the expense result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Description</th>
    <th>Amount</th>
    <th>Date</th>
    </tr>";
    
    //Writing the expense values.
    if (mysqli_num_rows($result_expenses_date) > 0) {

       while($row = mysqli_fetch_assoc($result_expenses_date)) {
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
   
   <div class="container">
   <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#dueListDate">Selected Due Table</button>
   <div id="dueListDate" class="collapse" style="max-width:900px;">
   <?php

    //Table to put the all debt result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Owner</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
    </tr>";
    
    //Writing the all debt values.
    if (mysqli_num_rows($result_debt_date) > 0) {

       while($row = mysqli_fetch_assoc($result_debt_date)) {
        echo "<tr>";   
        echo "<td>" . $row["owner"]. "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["status"]. "</td>";
        echo "<td>" . $row["date"] . "</td>";
        ?>
        <td><a href="payOthersDebt.php?due_number=<?php echo $row["due_number"]; ?> "><button id="button1" style="width: 60px; height:35px; padding:5px; margin:auto; color:white;">Pay</button></a></td>
        <?php
        echo "</tr>";
       }
    }
    echo "</table>";
    ?>
    </div>
    </div>

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
    <td><a href="addExpense.php"><button id="button1" style="width: 250px; height:50px; padding:5px; margin:auto; color:white;">Add New Expense</button></a></td>
    </div>
    </div>
   
   <div class="container">
   <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#dueList">Due Table</button>
   <div id="dueList" class="collapse" style="max-width:900px;">
   <?php

    //Table to put the all debt result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Owner</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
    </tr>";
    
    //Writing the all debt values.
    if (mysqli_num_rows($result_debt) > 0) {

       while($row = mysqli_fetch_assoc($result_debt)) {
        echo "<tr>";   
        echo "<td>" . $row["owner"]. "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["status"]. "</td>";
        echo "<td>" . $row["date"] . "</td>";
        ?>
        <td><a href="payOthersDebt.php?due_number=<?php echo $row["due_number"]; ?> "><button id="button1" style="width: 60px; height:35px; padding:5px; margin:auto; color:white;">Pay</button></a></td>
        <?php
        echo "</tr>";
       }
    }
    echo "</table>";
    ?>
    <td><a href="addDue.php"><button id="button1" style="width: 250px; height:50px; padding:5px; margin:auto; color:white;">Add New Due</button></a></td>
    </div>
    </div>
   <?php
    //Closing connection.
   mysqli_close($connection);
    ?>    
   </div>
</body>
</html>