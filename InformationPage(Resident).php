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
    <title>Information Page</title>
</head>
<body>
    <h1>Information</h1>
    <hr>
    <!-- Navbar to go between pages for resident. -->
    <?php include 'navbarResident.php';?>
    <!--Information box.-->
    <div id="box">
    <?php
    //Selecting information value from table.
    $sql = "SELECT info FROM info_table";
    $result = mysqli_query($connection, $sql);
    
    //Writing the selected values to information box.
    if (mysqli_num_rows($result) > 0) {

       while($row = mysqli_fetch_assoc($result)) {
           echo "-" . $row["info"]. "<br>";
       }
    }
    //Closing connection.
    mysqli_close($connection);
    ?>
    </div>
</body>
</html>