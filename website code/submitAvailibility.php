<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phplogin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$assigned_name = $_POST['assigned_name'];
$monday_start = $_POST['monday_start'];
$monday_end = $_POST['monday_end'];
$tuesday_start = $_POST['tuesday_start'];
$tuesday_end = $_POST['tuesday_end'];
$wednesday_start = $_POST['wednesday_start'];
$wednesday_end = $_POST['wednesday_end'];
$thursday_start = $_POST['thursday_start'];
$thursday_end = $_POST['thursday_end'];
$friday_start = $_POST['friday_start'];
$friday_end = $_POST['friday_end'];
$saturday_start = $_POST['saturday_start'];
$saturday_end = $_POST['saturday_end'];
$sunday_start = $_POST['sunday_start'];
$sunday_end = $_POST['sunday_end'];

// Prepare the SQL statement
$sql = "INSERT INTO availability (username, monday_start, monday_end, tuesday_start, tuesday_end, wednesday_start, wednesday_end, thursday_start, thursday_end, friday_start, friday_end, saturday_start, saturday_end, sunday_start, sunday_end) 
        VALUES ('$assigned_name', '$monday_start', '$monday_end', '$tuesday_start', '$tuesday_end', '$wednesday_start', '$wednesday_end', '$thursday_start', '$thursday_end', '$friday_start', '$friday_end', '$saturday_start', '$saturday_end', '$sunday_start', '$sunday_end')
        ON DUPLICATE KEY UPDATE 
        monday_start = '$monday_start', monday_end = '$monday_end', tuesday_start = '$tuesday_start', tuesday_end = '$tuesday_end', wednesday_start = '$wednesday_start', wednesday_end = '$wednesday_end', thursday_start = '$thursday_start', thursday_end = '$thursday_end', friday_start = '$friday_start', friday_end = '$friday_end', saturday_start = '$saturday_start', saturday_end = '$saturday_end', sunday_start = '$sunday_start', sunday_end = '$sunday_end'";

// Set success message
$_SESSION['success_msg'] = 'Hours submitted successfully.';
// Redirect to home page
// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
  // redirect back to original page with success message
    header('Location: availibility.php');
} else {
  echo "Error inserting data: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

