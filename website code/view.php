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
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  // Get the week from the URL parameter
  $week = $_GET["week"];

  // Retrieve the schedule data from the database
  $sql = "SELECT employees.name, schedule.day, schedule.hours FROM schedule INNER JOIN employees ON schedule.employee_id = employees.id WHERE schedule.week = '".$week."' ORDER BY employees.name ASC;";
  $result = $db->query($sql);

  // Display the schedule in a table
  echo "<table>";
  echo "<tr><th>Employee</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>Sunday</th></tr>";

  while($row = $result->fetch_assoc()) {
    $name = $row["name"];
    $day = $row["day"];
    $hours = $row["hours"];

    if (!isset($schedule[$name])) {
      $schedule[$name] = array("Monday" => "-", "Tuesday" => "-", "Wednesday" => "-", "Thursday" => "-", "Friday" => "-", "Saturday" => "-", "Sunday" => "-");
    }

    $schedule[$name][$day] = $hours;
  }

  foreach ($schedule as $name => $hours) {
    echo "<tr><td>".$name."</td><td>".$hours["Monday"]."</td><td>".$hours["Tuesday"]."</td><td>".$hours["Wednesday"]."</td><td>".$hours["Thursday"]."</td><td>".$hours["Friday"]."</td><td>".$hours["Saturday"]."</td><td>".$hours["Sunday"]."</td></tr>";
  }

  echo "</table>";

  $db->close();
?>