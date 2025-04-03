<?php
session_start();

// Ensure user is logged in and is a Patient
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'Patient') {
    header("Location: login.php");
    exit();
}

// Ensure session variables are set
$patient_name = isset($_SESSION['name']) ? $_SESSION['name'] : "Unknown";
$patient_email = isset($_SESSION['email']) ? $_SESSION['email'] : "Unknown";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : [];

    // Include "Other symptoms" if provided
    if (!empty($_POST['other_symptoms'])) {
        $symptoms[] = htmlspecialchars($_POST['other_symptoms']); // Prevent XSS
    }

    if (!empty($symptoms)) {
        // Format data
        $data = "$patient_name ($patient_email) reported: " . implode(", ", $symptoms) . "\n";

        // Save symptoms to a file (or you can save it to the database)
        file_put_contents("patients_symptoms.txt", $data, FILE_APPEND | LOCK_EX);

        echo "Symptoms submitted successfully! <a href='patient_home.php'>Go Back</a>";
        exit();
    } else {
        echo "<p style='color:red;'>Please select at least one symptom or enter an 'Other' symptom.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Symptoms</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($patient_name); ?>!</h2>
    <h3>Select Your Symptoms</h3>
    <form action="" method="POST">
        <label><input type="checkbox" name="symptoms[]" value="Cough"> Cough</label><br>
        <label><input type="checkbox" name="symptoms[]" value="Cold"> Cold</label><br>
        <label><input type="checkbox" name="symptoms[]" value="Diabetes"> Diabetes</label><br>
        <label><input type="checkbox" name="symptoms[]" value="BP"> High Blood Pressure (BP)</label><br>
        <label><input type="checkbox" name="symptoms[]" value="Heart Pain"> Heart Pain</label><br>

        <label>Other symptoms:</label>
        <input type="text" name="other_symptoms" placeholder="Enter other symptoms"><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
