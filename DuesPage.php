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
    <title>Dues Page</title>
</head>
<body>
    <h1>Dues</h1>
    <hr>
    <!-- Navbar to go between pages for resident or manager according to the value taken from session. -->
    <?php
    $current_username = $_SESSION["c_username"];
    $isManager = "SELECT isManager FROM users WHERE userName='$current_username' AND isManager='true'";
    $isManagerResult = mysqli_query($connection, $isManager);

    if (mysqli_num_rows($isManagerResult) > 0) {
     include 'navbarManager.php';
    }else{
     include 'navbarResident.php';
    }
    ?>
    <div id="box">
    <?php
    //Taking the current users username.
    $current_username = $_SESSION["c_username"];

    //Selecting the paid dues of the logged in user.
    $sql_debt_paid = "SELECT * FROM dues_table WHERE status='paid' AND owner='$current_username' ORDER BY date DESC";
    $result_debt_paid = mysqli_query($connection, $sql_debt_paid);

    ?>
    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#paidList">Paid Dues</button>
    <div id="paidList" class="collapse" style="max-width:900px;">
    <?php
    
    //Table to put the result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Owner</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
    </tr>";
    
    //Writing the values.
    if (mysqli_num_rows($result_debt_paid) > 0) {

       while($row = mysqli_fetch_assoc($result_debt_paid)) {
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
   <?php
    
    //Selecting the not paid dues of the logged in user.
    $sql_debt = "SELECT * FROM dues_table WHERE status='not paid' AND owner='$current_username' ORDER BY date DESC";
    $result_debt = mysqli_query($connection, $sql_debt);

    ?>
    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#notPaidList">Not Paid Dues</button>
    <div id="notPaidList" class="collapse" style="max-width:900px;">
    <?php
    
    //Table to put the result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Owner</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
    </tr>";
    
    //Writing the current users not paid debts and adding a pay button. If the button is clicked then "not paid" updated with "paid".
    if (mysqli_num_rows($result_debt) > 0) {

       while($row = mysqli_fetch_assoc($result_debt)) {
        echo "<tr>";
        echo "<td>" . $row["owner"]. "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["status"]. "</td>";
        echo "<td>" . $row["date"] . "</td>";
        ?>
        <td><a href="payDebt.php?due_number=<?php echo $row["due_number"]; ?> "><button id="button1" style="width: 60px; height:35px; padding:5px; margin:auto; color:white;">Pay</button></a></td>
        <?php
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