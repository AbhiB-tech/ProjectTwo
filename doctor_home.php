<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Doctor') {
    header("Location: login.php");
    exit();
}

// Read patient symptoms from file
$patients_data = file_exists("patients_problem.php") ? file_get_contents("patients_symptoms.txt") : "No patient data available.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['name']; ?> (Doctor)</h2>
    <h3>Patient Reports</h3>
    <pre><?php echo $patients_data; ?></pre>
    <a href="logout.php">Logout</a>
</body>
</html>
