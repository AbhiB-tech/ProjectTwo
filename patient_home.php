<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Patient') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Home</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['name']; ?> (Patient)</h2>
    <button onclick="window.location.href='patient_problem.php'">Select Symptoms</button>
    <a href="logout.php">Logout</a>
</body>
</html>
