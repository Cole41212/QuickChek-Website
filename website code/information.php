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
        Employee Information
    </h1>
    <div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table class="my-table">
					<tr>
						<td>Username:</td>
						<td class="my-table__cell"><?=$_SESSION['username']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td class="my-table__cell"><?=$password?></td>
					</tr>
					<tr>
						<td>First Name:</td>
						<td><?=$fName?></td>
					</tr>
                    <tr>
						<td>Last Name:</td>
						<td><?=$lName?></td>
					</tr>
				</table>
			</div>
		</div>
</body>
</html>