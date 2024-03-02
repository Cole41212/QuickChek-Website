<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
if ($_SESSION['username'] !== 'manager') {
  header('Location: home.php');
  exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QC Scheduling</title>
    <link rel="shortcut icon" type="image/jpg" href="images/qcLogo.jpg">
    <link rel="stylesheet" href="style.css">
</head>
<body class="loggedin">
  <div class="navigation">
    <div class="dropdown">
        <button class="dropbtn">Main</button>
        <div class="dropdown-content">
            <a href="home.php">Schedule</a>
        </div>
    </div>
    <div class="dropdown">
       	<button class="dropbtn">Employee Info</button>
        <div class="dropdown-content">
            <a href="information.php">Information</a>
            <a href="availibility.php">Availibility</a>
        </div>
    </div>  
    <div class="dropdown">
        <button class="dropbtn">Manager Tools</button>
        <div class="dropdown-content">
            <a href="Schedule Maker.php">Schedule Maker</a>
            <a href="employees.php">Employee List</a>
        </div>
    </div>         
    <div class="dropdown">
        <button class="dropbtn">Account</button>
        <div class="dropdown-content">
            <a href="logout.php">Logout</a>
        </div>
    </div>
	</div>
  <h1 class="logo">
      <img height="25" width="25" src="images/qcLogo.jpg">
      Employee Information
  </h1>

  <form action="submitSchedule.php" method="post">
    <label for="week">Select a week:</label>
		<input type="week" id="week" name="week" required>
    <table class="scheduleMaker">
      <tr>
        <th>Employee</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
      </tr>
      <?php
      $result = mysqli_query($conn, "SELECT * FROM accounts");
      while ($row = mysqli_fetch_assoc($result)) {
        $username = $row["username"]; // Get username from database
        $employee_name = $row['fName'] . ' ' . $row['lName'];
        echo "<tr>";
        echo "<td>" . $employee_name . "</td>";
        echo "<td><input type='time' name='" . $username . "_monday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_monday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "<td><input type='time' name='" . $username . "_tuesday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_tuesday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "<td><input type='time' name='" . $username . "_wednesday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_wednesday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "<td><input type='time' name='" . $username . "_thursday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_thursday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "<td><input type='time' name='" . $username . "_friday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_friday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "<td><input type='time' name='" . $username . "_saturday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_saturday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "<td><input type='time' name='" . $username . "_sunday_start' min='05:30' max='22:00' step='1800'> --- <input type='time' name='" . $username . "_sunday_end' min='05:30' max='22:00' step='1800'></td>";
        echo "</tr>";
        echo "<input type='hidden' name='" . $username . "_assigned_name' value='$username'>";
      }
      ?>
    </table>
    <br>
    <input class="avaSubmit" type="submit" value="Submit">
    <input class="avaReset" type="reset"></input>
  </form>
</body>
</html>


      
