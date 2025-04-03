<?php
// db_connect.php - Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "healthcare";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
// store_symptoms.php - Store symptoms
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symptoms = $_POST['symptoms'];
    $sql = "INSERT INTO symptoms (symptom_text) VALUES ('$symptoms')";
    $conn->query($sql);
    header("Location: index.php");
}
?>

<?php
// predict_disease.php - Predict disease using AI (Basic Example)
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symptoms = $_POST['symptoms'];
    $predicted_disease = "Flu"; // Replace with actual AI model integration
    header("Location: disease.php?disease=$predicted_disease");
}
?>

<?php
// disease.php - Fetch disease
include 'db_connect.php';
$sql = "SELECT * FROM diseases";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>Diseases</title></head>
<body>
    <h2>Diseases</h2>
    <ul>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <li><a href="description.php?disease=<?php echo $row['name']; ?>"><?php echo $row['name']; ?></a></li>
    <?php } ?>
    </ul>
</body>
</html>

<?php
// description.php - Fetch disease description
include 'db_connect.php';
if (isset($_GET['disease'])) {
    $disease = $_GET['disease'];
    $sql = "SELECT description FROM diseases WHERE name='$disease'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Description</title></head>
<body>
    <h2>Description of <?php echo $disease; ?></h2>
    <p><?php echo $row['description']; ?></p>
    <a href="precaution.php?disease=<?php echo $disease; ?>">Precautions</a>
</body>
</html>

<?php
// precaution.php - Fetch precautions
include 'db_connect.php';
if (isset($_GET['disease'])) {
    $disease = $_GET['disease'];
    $sql = "SELECT precautions FROM diseases WHERE name='$disease'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Precautions</title></head>
<body>
    <h2>Precautions for <?php echo $disease; ?></h2>
    <p><?php echo $row['precautions']; ?></p>
    <a href="medications.php?disease=<?php echo $disease; ?>">Medications</a>
</body>
</html>

<?php
// medications.php - Fetch medications
include 'db_connect.php';
if (isset($_GET['disease'])) {
    $disease = $_GET['disease'];
    $sql = "SELECT medications FROM diseases WHERE name='$disease'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Medications</title></head>
<body>
    <h2>Medications for <?php echo $disease; ?></h2>
    <p><?php echo $row['medications']; ?></p>
    <a href="workouts.php?disease=<?php echo $disease; ?>">Workouts</a>
</body>
</html>

<?php
// workouts.php - Fetch workouts
include 'db_connect.php';
if (isset($_GET['disease'])) {
    $disease = $_GET['disease'];
    $sql = "SELECT workouts FROM diseases WHERE name='$disease'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Workouts</title></head>
<body>
    <h2>Workouts for <?php echo $disease; ?></h2>
    <p><?php echo $row['workouts']; ?></p>
    <a href="diet.php?disease=<?php echo $disease; ?>">Diet</a>
</body>
</html>

<?php
// diet.php - Fetch diet recommendations
include 'db_connect.php';
if (isset($_GET['disease'])) {
    $disease = $_GET['disease'];
    $sql = "SELECT diet FROM diseases WHERE name='$disease'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Diet</title></head>
<body>
    <h2>Diet for <?php echo $disease; ?></h2>
    <p><?php echo $row['diet']; ?></p>
    <a href="index.php">Home</a>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Healthcare System</title>
</head>
<body>
    <h2>Healthcare System</h2>
    <form action="store_symptoms.php" method="POST">
        <label>Enter Symptoms:</label>
        <input type="text" name="symptoms" required>
        <button type="submit">Submit</button>
    </form>

    <form action="predict_disease.php" method="POST">
        <label>Predict Disease:</label>
        <input type="text" name="symptoms" required>
        <button type="submit">Predict</button>
    </form>
    
    <button onclick="window.location.href='disease.php'">View Diseases</button>
</body>
</html>