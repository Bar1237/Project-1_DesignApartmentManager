<!-- Current users name and current date. -->
<div class="navbar" style="width:20%; height:70px; color:white; text-align:center; font-size:19px;">
   <?php
   $current_fullname = $_SESSION["c_fullname"];
   echo "$current_fullname";
   ?> 
<br>
   <?php
   $currentDate= date("d-m-Y");
   echo "$currentDate";
   ?> 
</div>

<!-- Navbar to go between pages for manager. -->
<div class="navbar">
   <li class="dropdown" style="display:inline-block;"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Residents <span class="caret"></span></a>
      <ul class="dropdown-menu" style="background-color:#333;">
         <li><div class="navbar" style="margin:0px;"><a style="width:160px;" href="ResidentListPage(Manager).php">Resident List</a></div></li>
         <li><div class="navbar" style="margin:0px;"><a style="width:160px;" href="OldResidentListPage.php">Old Resident List</a></div></li>
         <li><div class="navbar" style="margin:0px;"><a style="width:160px;" href="UserRegistrationPage.php">Register User</a></div></li>
         <li><div class="navbar" style="margin:0px;"><a style="width:160px;" href="ResidentRegistrationPage.php">Register Resident</a></div></li>
      </ul>
      </li>
      <li style="display:inline;"><a href="AccountPage(Manager).php">Account</a></li>
      <li style="display:inline;"><a href="AnnouncementPage(Manager).php">Announcement</a></li>
      <li style="display:inline;"><a href="InformationPage(Manager).php">Information</a></li>
      <li style="display:inline;"><a href="IncomeExpensesPage(Manager).php">Incomes/Expenses</a></li>
      <a href="DuesPage.php">Dues</a>
      <li style="display:inline;"><a id="logOut" href="LogOut.php">Log Out</a></li>
</div>