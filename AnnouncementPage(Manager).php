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
    <title>Announcement Page</title>
</head>
<body>
    <h1>Announcements</h1>
    <hr>
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>
    <!--Announcement box.-->
    <div id="box">
    <?php
    //Selecting announcement value from table.
    $sql = "SELECT ann FROM announcement_table";
    $result = mysqli_query($connection, $sql);
    
    //Writing the selected values to announcement box.
    if (mysqli_num_rows($result) > 0) {

       while($row = mysqli_fetch_assoc($result)) {
           echo "-" . $row["ann"]. "<br>";
       }
    }
    
    //Taking the value from the form and inserting into database.
    if(isset($_POST['announcement_button'])){
        $Ann=test_input($_POST['newAnnouncement']);
        
        $sqlMakeAnn = "INSERT INTO `announcement_table` (`ann_number`, `ann`) VALUES (NULL, '$Ann');";

        if (mysqli_query($connection, $sqlMakeAnn)) {
            echo '<script language="javascript">';
            echo 'alert("Announcement Made")';
            echo '</script>';
        }else{
            echo '<script language="javascript">';
            echo 'alert("Error:Can not make announcement!")';
            echo '</script>';
        }
    }

    //If the clear button is clicked then announcement tables content is copied to another table then droped.
    if(isset($_POST['clear_button'])){
        $sqlCopyAnn= "INSERT INTO announcement_table_storage SELECT * FROM announcement_table";
        mysqli_query($connection, $sqlCopyAnn);
        $sqlDeleteAnn = "DELETE FROM announcement_table";
        
        if (mysqli_query($connection, $sqlDeleteAnn)) {
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
    
    <!--Announcement button and text field to add a new announcement to box.-->
    <div>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="text" name="newAnnouncement" id="textBox1" placeholder="Enter new announcement here.">
        <input type="submit" name="announcement_button" id="button1" value="Make Announcement">
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