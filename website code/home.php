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
<html>
	<head>
		<meta charset="utf-8">
		<title>QC Schedule</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
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
    		QuickChek Schedule
		</h1>
		<div class="content">
			<h2>This weeks schedule:</h2>
			<table>
    			<tr>
        			<th>Employee</th>
        			<th>25 March (Saturday)</th>
        			<th>26 March (Sunday)</th>
        			<th>27 March (Monday)</th>
        			<th>28 March (Tuesday)</th>
        			<th>29 March (Wednesday)</th>
        			<th>30 March (Thursday)</th>
        			<th>31 March (Friday)</th>
    			</tr>
    			<tr>
    			<tr>
        			<td>Valarie Ghnim</td>
        			<td style="background-color: rgb(111, 111, 253);">2:00p-10:00p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">4:00p-10:00p</td>
       			 	<td></td>
        			<td style="background-color: rgb(111, 111, 253);">4:00p-10:00p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">4:00p-10:00p</td>
    			</tr>
    			<tr>
        			<td>Scooby-Doo</td>
        			<td style="background-color: rgb(111, 111, 253);">2:00p-10:00p</td>
        			<td></td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">10:00-6:00p</td>
        			<td style="background-color: rgb(111, 111, 253);">10:00-6:00p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">10:00-6:00p</td>
    			</tr>
    			<tr>
        			<td>Cole Brink</td>
        			<td style="background-color: rgb(253, 111, 229);">10:00-4:00p</td>
        			<td></td>
        			<td ></td>
        			<td style="background-color: rgb(111, 111, 253);">6:00p-10:00p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">6:00p-10:00p</td>
        			<td></td>
    			</tr>
    			<tr>
        			<td>Superman</td>
        			<td style="background-color: rgb(253, 111, 229);">5:30-2:30p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">12:30p-10:00p</td>
        			<td style="background-color: rgb(111, 111, 253);">1:00p-10:00p</td>
        			<td style="background-color: rgb(111, 111, 253);">1:00p-10:00p</td>
        			<td style="background-color: rgb(253, 111, 229);">8:00-4:00p</td>
        			<td></td>
    			</tr>
    			<tr>
        			<td>Nick Rankin</td>
        			<td style="background-color: rgb(253, 111, 229);">10:00-2:00p</td>
        			<td style="background-color: rgb(253, 111, 229);">10:00-2:00p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">6:00p-10:00p</td>
        			<td></td>
        			<td style="background-color: rgb(111, 111, 253);">6:00p-10:00p</td>
        			<td></td>
    			</tr>
			</table>
		</div>
	</body>
</html>