<?php
// Start the session
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
    <link rel="stylesheet" href="JoinPageStyle.css">
    <?php include 'databaseConnection.php';?>
    <title>Apartment Manager Join Page</title>
</head>
<body>
    <h1>Welcome To Our Apartment</h1>
    <hr>
    <!--Join box to enter username and password.-->
    <div class="joinBox">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
       <div class="formContent">
       <input type="text" name="username" placeholder="Username"><br>
       <input type="password" name="password" placeholder="Password"><br>
       <input type="submit" name="submit_button" value="Login">
       </div>
    </form>
    </div>
</body>
</html>

<?php
//If the form is set then the each data taken from the form are taken to the test_input function and then assigned to the variables.
if(isset($_POST['submit_button'])){
    $username=test_input($_POST['username']);
    $password=md5(test_input($_POST['password']));
    
    // Set session variables
    $_SESSION["c_username"] = "$username";
    
    //Checking if any of the variables is empty. If there are empty ones then an error message is given to user.
    if((empty($username))or(empty($password))){
        echo '<script language="javascript">';
        echo 'alert("Please enter all the information.")';
        echo '</script>';
    //If all the required information is entered then it compares the forum values with the database values.    
    }else{
    $queryAdmin="SELECT * FROM `users` WHERE userName='$username' AND userPassword='$password' AND isManager='true'";
    $resultAdmin=mysqli_query($connection,$queryAdmin);
    $rowsAdmin=mysqli_num_rows($resultAdmin);

    $queryResident="SELECT * FROM `users` WHERE userName='$username' AND userPassword='$password' AND isManager='false'";
    $resultResident=mysqli_query($connection,$queryResident);
    $rowsResident=mysqli_num_rows($resultResident);

        if($rowsAdmin==1){
           header("Location: AnnouncementPage(Manager).php");
        }else if ($rowsResident==1){
           header("Location: AnnouncementPage(Resident).php");
        }else{
           echo '<script language="javascript">';
           echo 'alert("Wrong Username or Password")';
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