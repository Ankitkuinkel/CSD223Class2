<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anitaku's Bank</title>
    <!-- Add any necessary CSS stylesheets or links here -->
</head>
<body>

<?php include('navbar.php'); ?>

<?php
// Database credentials for XAMPP
$host = 'localhost'; // Change this to your database host (usually 'localhost' for XAMPP)
$username = 'root'; // Change this to your database username (default is 'root' for XAMPP)
$password = ''; // Change this to your database password (default is empty for XAMPP)
$database = 'csd223_ankitkuinkel';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<div class="hero-area text-center">
    <h1 class="red">Welcome to Anitaku's Bank</h1>

    <?php
    for ($paragraphNumber = 1; $paragraphNumber <= 10; $paragraphNumber++) {
        echo "<p>Paragraph $paragraphNumber</p>";
    }
    ?>

</div>

<?php
// Close the database connection when done
$conn->close();
?>

<?php include('footer.php'); ?>

<!-- Add any necessary JavaScript scripts or links here -->

</body>
</html>
