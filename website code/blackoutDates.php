<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT password, fName, lName FROM accounts WHERE id = ?');
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
        Employee Availibility
    </h1>
    <section class="all-menu">
        <article class ="menu">
            <a href="availibility.php">Weekly Availibility</a>
        </article>
        <section class ="menu">
            <a href="updateAvailibility.php">Update Availibility</a>
        </section>
        <section class ="selected">
            <a href="blackoutDates.php">Blackout Dates</a>
        </section>
    </section>
    <aside>
		<h1 class="blackout">Update Blackout Dates</h1>
		<form action="submitBlackouts.php" method="post">
			<table class="blackouts-form">
				<tr>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
				<tr>
					<td><input class="funstyle" type="date" id="starting_date" name="starting_date" min="<?php echo date('Y-m-d', strtotime('+2 weeks')); ?>" required></td>
					<td><input class="funstyle" type="date" id="end_date" name="end_date" min="<?php echo date('Y-m-d', strtotime('+2 weeks')); ?>" required></td>
				</tr>
				<input type="hidden" name="assigned_name" value=<?=$_SESSION['username']?>>
				<input class="blackoutSubmit" type="submit" value="Submit">
				<input class="blackoutReset" type="reset"></input>
			</table>
		</form>
    </aside>
</body>
</html>