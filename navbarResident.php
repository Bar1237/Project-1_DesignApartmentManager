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

<!-- Navbar to go between pages for resident. -->
<div class="navbar">
  <a href="AccountPage(Resident).php">Account</a>
  <a href="AnnouncementPage(Resident).php">Announcement</a>
  <a href="InformationPage(Resident).php">Information</a>
  <a href="IncomeExpensesPage(Resident).php">Incomes/Expenses</a>
  <a href="DuesPage.php">Dues</a>
  <a id="logOut" href="LogOut.php">Log Out</a>
</div>