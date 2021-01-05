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
<body >
    <h1>Information</h1>
    <hr>
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>
    
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
    
    //Taking the value from the form and inserting into database.
    if(isset($_POST['information_button'])){
        $Info=test_input($_POST['newInfo']);
        
        $sqlMakeInfo = "INSERT INTO `info_table` (`info_number`, `info`) VALUES (NULL, '$Info');";

        if (mysqli_query($connection, $sqlMakeInfo)) {
            echo '<script language="javascript">';
            echo 'alert("Information Added")';
            echo '</script>';
        }else{
            echo '<script language="javascript">';
            echo 'alert("Error:Can not add information!")';
            echo '</script>';
        }
    }

    //If the clear button is clicked then info tables content is copied to another table then droped.
    if(isset($_POST['clear_button'])){
        $sqlCopyInfo= "INSERT INTO info_table_storage SELECT * FROM info_table";
        mysqli_query($connection, $sqlCopyInfo);
        $sqlDeleteInfo = "DELETE FROM info_table";
        
        if (mysqli_query($connection, $sqlDeleteInfo)) {
            echo '<script language="javascript">';
            echo 'alert("Box is cleared.")';
            echo '</script>';
        }else{
            echo '<script language="javascript">';
            echo 'alert("Error:Box can not cleared!")';
            echo '</script>';
        }
    }

    //Closing connection.
    mysqli_close($connection);
    
    //Function to check the data.
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    </div>
    
    <!--Information button and text field to add a new info to box.-->
    <div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="text" name="newInfo" id="textBox1" placeholder="Enter new information here.">
        <input type="submit" name="information_button" id="button1" value="Add Information">
    </form>
    </div>

    <!--Clear button to clear the info box.-->
    <div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
        <input type="submit" name="clear_button" id="button1" value="Clear The Box">
    </form>  
    </div>
</body>
</html>