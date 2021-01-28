<?php
session_start();
error_reporting(0);
//Connecting to database.
include 'databaseConnection.php';

//Getting the userID
$userID = $_GET["userID"];

//Defining variables and setting them empty for now.
$fullName = $email = $phoneNumberOne = $phoneNumberTwo = "";

//Selecting the users info with the id.
$sql_curr_user = "SELECT fullName, email, phoneNumberOne, phoneNumberTwo, gender FROM `users` WHERE id='$userID'";
$result_curr_user = mysqli_query($connection, $sql_curr_user);

//Taking the current users current info to display in the input boxes.
if (mysqli_num_rows($result_curr_user) > 0) {

    while($row = mysqli_fetch_assoc($result_curr_user)) {  
       $fullName = $row["fullName"];
       $email = $row["email"];
       $phoneNumberOne = $row["phoneNumberOne"];
       $phoneNumberTwo = $row["phoneNumberTwo"];
    }
 }
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
    <title>Update Page</title>
</head>
<body>
    <h1>Update User Info</h1>
    <hr>
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>

    <!--Form to take the updated values of the user. If a mistake is made in any of the values user will not have to enter every value again. They are kept.-->
    <div id="box">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br>

        <label for="ID">Users ID:</label>
        <input type="text" id="ID" name="usersID" readonly="readonly" value="<?php echo $userID;?>" /><br><br>

        <label for="fullNameID">Full Name:</label>
        <input type="text" id="fullNameID" name="fullName" value="<?php echo $fullName;?>" /><br><br>

        <label for="emailID" style="margin-right:23px;">E-mail:</label>
        <input type="text" id="emailID" name="email" value="<?php echo $email;?>" /><br><br>
        
        <label for="phoneNumberOneID">Number 1:</label>
        <input type="text" id="phoneNumberOneID" name="phoneNumberOne" value="<?php echo $phoneNumberOne;?>" /><br><br>
        
        <label for="phoneNumberTwoID">Number 2:</label>
        <input type="text" id="phoneNumberTwoID" name="phoneNumberTwo" value="<?php echo $phoneNumberTwo;?>" /><br><br>

        <label for="doorNumberID">Door Number:</label>
        <select name="doorNumber" class="btn btn-primary dropdown-toggle" id="doorNumberID" style="background-color:#333; width:100px;">
        <option value="1" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="1") echo "selected";?>>1</option>
        <option value="2" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="2") echo "selected";?>>2</option>
        <option value="3" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="3") echo "selected";?>>3</option>
        <option value="4" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="4") echo "selected";?>>4</option>
        <option value="5" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="5") echo "selected";?>>5</option>
        <option value="6" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="6") echo "selected";?>>6</option>
        <option value="7" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="7") echo "selected";?>>7</option>
        <option value="8" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="8") echo "selected";?>>8</option>
        <option value="9" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="9") echo "selected";?>>9</option>
        <option value="10" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="10") echo "selected";?>>10</option>
        <option value="11" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="11") echo "selected";?>>11</option>
        <option value="12" <?php if (isset($_POST['doorNumber']) && $_POST['doorNumber']=="12") echo "selected";?>>12</option>
        </select><br><br>
        
        <label>Gender:</label>
        <input type="radio" name="gender" style="margin-left:22px;" value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'male')  echo ' checked="checked"';?> /> Male
        <input type="radio" name="gender" style="margin-left:22px;" value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'female')  echo ' checked="checked"';?> /> Female
        <input type="radio" name="gender" style="margin-left:22px;" value="other" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'other')  echo ' checked="checked"';?> /> Other<br><br>

        <label>Manager:</label>
        <input type="radio" name="manager" style="margin-left:12px;" value="true" <?php if (isset($_POST['manager']) && $_POST['manager'] == 'true')  echo ' checked="checked"';?> /> True
        <input type="radio" name="manager" style="margin-left:25px;" value="false" <?php if (isset($_POST['manager']) && $_POST['manager'] == 'false')  echo ' checked="checked"';?> /> False<br><br>
        
        <input type="submit" name="update_button" id="button1" value="Update" style="width: 252px;">
        </form>
    </div>
</body>
</html>

<?php
//If the form is set then the each data taken from the form are taken to the test_input function and then assigned to the variables.
if(isset($_POST['update_button'])){

    $usersID=test_input($_POST['usersID']);

    $fullName=test_input($_POST['fullName']);
    
    $email=test_input($_POST['email']);
    
    $phoneNumberOne=test_input($_POST['phoneNumberOne']);
    
    $phoneNumberTwo=test_input($_POST['phoneNumberTwo']);

    $doorNumber=test_input($_POST['doorNumber']);
    
    $gender=test_input($_POST['gender']);

    $manager=test_input($_POST['manager']);
      
    //Checking if any of the variables is empty. If there are empty ones then the data is not updated and error message is given to user.
    if((empty($doorNumber))or(empty($fullName))or(empty($email))or(empty($phoneNumberOne))or(empty($phoneNumberTwo))or(empty($gender))or(empty($manager))){
        echo '<script language="javascript">';
        echo 'alert("Please enter all the information.")';
        echo '</script>';
    //Checking the fullName variable. If it contains any not allowed characters it will warn the user.
    }else if(!preg_match("/^[a-zA-Z-ç-Ç-ğ-Ğ-İ-ı-ş-Ş-ü-Ü-ö-Ö' ]*$/",$fullName)){
        echo '<script language="javascript">';
        echo 'alert("Only letters and whitespace allowed for Full Name.")';
        echo '</script>';
    //Checking the email variable. If it is an invalid email format it will warn the user.
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script language="javascript">';
        echo 'alert("Invalid E-mail format.")';
        echo '</script>';
    //Checking the phoneNumberOne variable. If it contains any not allowed characters it will warn the user.
    }else if(!preg_match("/^[0-9]*$/",$phoneNumberOne)){
        echo '<script language="javascript">';
        echo 'alert("Invalid phone number for Phone Number 1.")';
        echo '</script>';
    //Checking the phoneNumberTwo variable. If it contains any not allowed characters it will warn the user.
    }else if(!preg_match("/^[0-9]*$/",$phoneNumberTwo)){
        echo '<script language="javascript">';
        echo 'alert("Invalid phone number for Phone Number 2.")';
        echo '</script>';
    //If all of the required data is entered and they are using allowed characters then database is updated.
    }else{
    
    $sqlUpdate = "UPDATE `users` SET doorNumber = '$doorNumber', fullName = '$fullName', email = '$email', phoneNumberOne = '$phoneNumberOne', phoneNumberTwo = '$phoneNumberTwo', gender = '$gender', isManager = '$manager' WHERE id='$usersID'";
    
    if (mysqli_query($connection, $sqlUpdate)) {
        echo '<script language="javascript">';
        echo 'alert("Update Completed")';
        echo '</script>';
      } else {
        echo '<script language="javascript">';
        echo 'alert("Error:Update can not completed!")';
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