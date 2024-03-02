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


// Get the selected week from the form submission
$week_number = $_POST['week'];

// Check if the table for the selected week exists
$table_name = str_replace('-', '_', $week_number);
$table_exists = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($table_exists) == 0) {
    // Create the table if it doesn't exist
    $sql = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        monday_start TIME,
        monday_end TIME,
        tuesday_start TIME,
        tuesday_end TIME,
        wednesday_start TIME,
        wednesday_end TIME,
        thursday_start TIME,
        thursday_end TIME,
        friday_start TIME,
        friday_end TIME,
        saturday_start TIME,
        saturday_end TIME,
        sunday_start TIME,
        sunday_end TIME
    )";
    mysqli_query($conn, $sql);
}

$result = mysqli_query($conn, "SELECT * FROM accounts");
while ($row = mysqli_fetch_assoc($result)) {
  $username = $row["username"]; // Get username from database
  // Get the form data
  $assigned_name = $_POST[$username . "_assigned_name"];
  $monday_start = $_POST[$username . "_monday_start"];
  $monday_end = $_POST[$username . "_monday_end"];
  $tuesday_start = $_POST[$username . "_tuesday_start"];
  $tuesday_end = $_POST[$username . "_tuesday_end"];
  $wednesday_start = $_POST[$username . "_wednesday_start"];
  $wednesday_end = $_POST[$username . "_wednesday_end"];
  $thursday_start = $_POST[$username . "_thursday_start"];
  $thursday_end = $_POST[$username . "_thursday_end"];
  $friday_start = $_POST[$username . "_friday_start"];
  $friday_end = $_POST[$username . "_friday_end"];
  $saturday_start = $_POST[$username . "_saturday_start"];
  $saturday_end = $_POST[$username . "_saturday_end"];
  $sunday_start = $_POST[$username . "_sunday_start"];
  $sunday_end = $_POST[$username . "_sunday_end"];
  
  echo "{$assigned_name}";
  echo "{$table_name}";
  echo "{$username}";
  echo "{$tuesday_start}";
  // Prepare the SQL statement
  $table_name = str_replace('-', '_', $week_number);
  $sql = "INSERT INTO $table_name (username, monday_start, monday_end, tuesday_start, tuesday_end, wednesday_start, wednesday_end, thursday_start, thursday_end, friday_start, friday_end, saturday_start, saturday_end, sunday_start, sunday_end) 
          VALUES ('$assigned_name', '$monday_start', '$monday_end', '$tuesday_start', '$tuesday_end', '$wednesday_start', '$wednesday_end', '$thursday_start', '$thursday_end', '$friday_start', '$friday_end', '$saturday_start', '$saturday_end', '$sunday_start', '$sunday_end')
          ON DUPLICATE KEY UPDATE 
          monday_start = '$monday_start', monday_end = '$monday_end', tuesday_start = '$tuesday_start', tuesday_end = '$tuesday_end', wednesday_start = '$wednesday_start', wednesday_end = '$wednesday_end', thursday_start = '$thursday_start', thursday_end = '$thursday_end', friday_start = '$friday_start', friday_end = '$friday_end', saturday_start = '$saturday_start', saturday_end = '$saturday_end', sunday_start = '$sunday_start', sunday_end = '$sunday_end'";
  echo "done";
}

$_SESSION['success_msg'] = 'Hours submitted successfully.';
// Redirect to home page
// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
  // redirect back to original page with success message
    header('Location: Schedule Maker.php');
} else {
  echo "Error inserting data: " . $conn->error;
}
// Close the database connection
$conn->close();

?>