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
    <title>Old Resident List</title>
</head>
<body>
    <h1>Old Resident List</h1>
    <hr>
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>

    <!--Old Resident List.-->
    <div id="box">
    <?php
    //Selecting all of the moved out user information from table.
    $sql_o = "SELECT * FROM move_out_users ORDER BY doorNumber ASC";
    $result_o = mysqli_query($connection, $sql_o);
    ?>

    <div class="container">
    <button type="button" class="btn btn-info" id="button1" style="width: 50%; height: 65px; display:inline-block; margin-left:165px;;" data-toggle="collapse" data-target="#resListOld">Old Resident List</button>
    <div id="resListOld" class="collapse" style="max-width:930px;">
    <?php
    
    //Table to put the result.
    echo "<table border='1' class='table table-hover'>
    <tr>
    <th>Username</th>
    <th>Full Name</th>
    <th>Manager</th>
    <th>Door Number</th>
    <th>E-mail</th>
    <th>Phone Number One</th>
    <th>Phone Number Two</th>
    <th>Gender</th>
    <th>Move In Date</th>
    <th>Move Out Date</th>
    </tr>";
    
    //Writing the selected values.
    if (mysqli_num_rows($result_o) > 0) {
        
        while($row = mysqli_fetch_assoc($result_o)) {
        echo "<tr>";   
        echo "<td>" . $row["userName"]. "</td>";
        echo "<td>" . $row["fullName"] . "</td>";
        echo "<td>" . $row["isManager"]. "</td>";
        echo "<td>" . $row["doorNumber"] . "</td>";
        echo "<td>" . $row["email"]. "</td>";
        echo "<td>" . $row["phoneNumberOne"] . "</td>";
        echo "<td>" . $row["phoneNumberTwo"]. "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["moveInDate"]. "</td>";
        echo "<td>" . $row["moveOutDate"] . "</td>";
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