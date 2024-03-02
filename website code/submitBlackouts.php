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
$starting_date = $_POST['starting_date'];
$end_date = $_POST['end_date'];

// Prepare the SQL statement
$sql = "INSERT INTO blackouts (username, starting_date, end_date) 
        VALUES ('$assigned_name', '$starting_date', '$end_date')
        ON DUPLICATE KEY UPDATE 
        starting_date = '$starting_date', end_date = '$end_date'";

// Set success message
$_SESSION['success_msg'] = 'Dates submitted successfully.';
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