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
    <title>Resident Registration Page</title>
</head>
<body>
    <h1>Resident Registration Page</h1>
    <hr>
    <!-- Navbar to go between pages for manager. --> 
    <?php include 'navbarManager.php';?>

    <!--Form to take the values of the new resident. If a mistake is made in any of the values user will not have to enter every value again. They are kept.-->
    <div id="box">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br>
        
        <label for="fullNameID">Full Name:</label>
        <input type="text" id="fullNameID" name="fullName" placeholder="Example:John Doe" value="<?php echo isset($_POST['fullName']) ? $_POST['fullName'] : '' ?>" /><br><br>

        <label for="emailID" style="margin-right:23px;">E-mail:</label>
        <input type="text" id="emailID" name="email" placeholder="example@hotmail.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" /><br><br>
        
        <label for="phoneNumberOneID">Number 1:</label>
        <input type="text" id="phoneNumberOneID" name="phoneNumberOne" placeholder="05000000000" value="<?php echo isset($_POST['phoneNumberOne']) ? $_POST['phoneNumberOne'] : '' ?>" /><br><br>
        
        <label for="phoneNumberTwoID">Number 2:</label>
        <input type="text" id="phoneNumberTwoID" name="phoneNumberTwo" placeholder="05000000000" value="<?php echo isset($_POST['phoneNumberTwo']) ? $_POST['phoneNumberTwo'] : '' ?>" /><br><br>

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

        <label for="dateIn">Move In Date:</label>
        <input type="date" id="dateIn" name="dateIn" class="form-control" style="width:200px; display:inline-block;" value="<?php echo isset($_POST['dateIn']) ? $_POST['dateIn'] : '' ?>" /><br><br>
        
        <input type="submit" name="register_button" id="button1" value="Register" style="width: 252px;">
        </form>
    </div>
</body>
</html>

<?php
//If the form is set then the each data taken from the form are taken to the test_input function and then assigned to the variables.
if(isset($_POST['register_button'])){
    $fullName=test_input($_POST['fullName']);

    $doorNumber=test_input($_POST['doorNumber']);

    $email=test_input($_POST['email']);

    $phoneNumberOne=test_input($_POST['phoneNumberOne']);

    $phoneNumberTwo=test_input($_POST['phoneNumberTwo']);

    $gender=test_input($_POST['gender']);

    $moveInDate=test_input($_POST['dateIn']);
      
    //Checking if any of the variables is empty. If there are empty ones then the data is not stored to database and error message is given to user.
    if((empty($fullName))or(empty($doorNumber))or(empty($email))or(empty($phoneNumberOne))or(empty($phoneNumberTwo))or(empty($gender))or(empty($moveInDate))){
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
    //If all of the required data is entered and they are using allowed characters then it is saved to database.
    }else{

    $sqlRegister = "INSERT INTO `users` (userName, userPassword, fullName, isManager, doorNumber, email, phoneNumberOne, phoneNumberTwo, gender, moveInDate)
    VALUES ('', '', '$fullName', '', '$doorNumber', '$email', '$phoneNumberOne', '$phoneNumberTwo', '$gender', '$moveInDate')";
    
    if (mysqli_query($connection, $sqlRegister)) {
        echo '<script language="javascript">';
        echo 'alert("Registration Completed")';
        echo '</script>';
      } else {
        echo '<script language="javascript">';
        echo 'alert("Error:Can not register!")';
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