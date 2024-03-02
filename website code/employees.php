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
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $conn->prepare('SELECT password, fName, lName FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $fName, $lName);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QC Scheduling</title>
    <link rel="shortcut icon" type="image/jpg" href="images/qcLogo.jpg">
    <link rel="stylesheet" href="style.css">
</head>
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
        Employee List
    </h1>
<body>
    <h1 class="showAvailability">Current Availability</h1>
        <?php
		$sql = "SELECT * FROM availability";
        $result = mysqli_query($conn, $sql);
		// Check if there are any rows returned
		if (mysqli_num_rows($result) > 0) {
			// Display the table header
			echo "<table class='showAvailability'>";
			echo "<tr><th>Username</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>Sunday</th></tr>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $row["username"] . "</td>";
				echo "<td>" . $row["monday_start"] . "  -  " . $row["monday_end"] . "</td>";
				echo "<td>" . $row["tuesday_start"] . "  -  " . $row["tuesday_end"] . "</td>";
				echo "<td>" . $row["wednesday_start"] . "  -  " . $row["wednesday_end"] . "</td>";
				echo "<td>" . $row["thursday_start"] . "  -  " . $row["thursday_end"] . "</td>";
				echo "<td>" . $row["friday_start"] . "  -  " . $row["friday_end"] . "</td>";
				echo "<td>" . $row["saturday_start"] . "  -  " . $row["saturday_end"] . "</td>";
				echo "<td>" . $row["sunday_start"] . "  -  " . $row["sunday_end"] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			// If no rows returned, display a message
			echo "No availability data found for user: $username";
		}

		//BLACKOUT DATES TABLE
		$sql = "SELECT * FROM blackouts";
        $result = mysqli_query($conn, $sql);
		// Check if there are any rows returned
		if (mysqli_num_rows($result) > 0) {
			// Display the table header
			echo "<table class='showBlackouts'>";
			echo "<tr><th>Username</th><th>Blackout Dates</th></tr>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>" . $row["username"] . "</td>";
				echo "<td>" . $row["starting_date"] . "  -  " . $row["end_date"] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			// If no rows returned, display a message
			echo "No blackout date data found for user: $username";
		}
		
		?>
		<?php if (isset($successMsg)) { ?>
    	<script>
        	alert('<?php echo $successMsg; ?>');
    	</script>
		<?php } ?>
</body>
</html>