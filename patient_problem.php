<?php
session_start();
if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] !== "patient") {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['user_email'];
    $symptoms = implode(", ", $_POST['symptoms']); // Convert array to string

    // Database connection
    $conn = new mysqli("localhost", "root", "", "healthcare_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert or update patient symptoms
    $sql = "INSERT INTO patients (name, email, symptoms) 
            VALUES ('".$_SESSION['user_name']."', '$email', '$symptoms') 
            ON DUPLICATE KEY UPDATE symptoms='$symptoms'";

    if ($conn->query($sql) === TRUE) {
        echo "Symptoms submitted successfully. <a href='patient_home.php'>Go Back</a>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Problem</title>
</head>
<body>
    <h2>Select Your Symptoms</h2>
    <form method="POST">
        <input type="checkbox" name="symptoms[]" value="Cough"> Cough<br>
        <input type="checkbox" name="symptoms[]" value="Fever"> Fever<br>
        <input type="checkbox" name="symptoms[]" value="Cold"> Cold<br>
        <input type="checkbox" name="symptoms[]" value="BP"> High Blood Pressure (BP)<br>
        <input type="checkbox" name="symptoms[]" value="Sugar"> Diabetes (Sugar)<br>
        <input type="checkbox" name="symptoms[]" value="Other"> Other<br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
