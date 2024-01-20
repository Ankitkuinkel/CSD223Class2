<?php
// Initialize error and success messages
$error_message = '';
$success_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input (add more validation as needed)
    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required.";
    } else {
        // Database credentials
        $host = 'localhost';
        $username = 'root';
        $db_password = '';
        $database = 'csd223_ankitkuinkel';

        // Create connection
        $conn = new mysqli($host, $username, $db_password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM tbl_user WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify the password
            if ($password === $row['password']) {
                // Authentication successful
                $success_message = "Sign-in successful!";
                
                // Store user ID in session
                session_start();
                $_SESSION['user_id'] = $row['id'];
                
                // Redirect to the user details page
                header('Location: user-details.php');
                exit();
            } else {
                // Authentication failed
                $error_message = "Invalid email or password.";
            }
        } else {
            // User not found
            $error_message = "Invalid email or password.";
        }

        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anitaku's Bank - Login</title>
    <!-- Add any necessary CSS stylesheets or links here -->
</head>
<body>

<?php include('navbar.php'); ?>

<br>
<br>
<br>
<br>

<div class="login-area col-md-4 offset-md-4">
    <form method="post" action="">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <input type="email" name="email" id="form2Example1" class="form-control" />
            <label class="form-label" for="form2Example1">Email address</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <input type="password" name="password" id="form2Example2" class="form-control" />
            <label class="form-label" for="form2Example2">Password</label>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
            <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
            </div>

            <div class="col">
                <!-- Simple link -->
                <a href="your_forgot_password_page.php">Forgot password?</a>
            </div>
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

        <!-- Display error or success messages -->
        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php elseif (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Not a member? <a href="your_register_page.php">Register</a></p>
            <p>or sign up with:</p>
            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-google"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
                <i class="fab fa-github"></i>
            </button>
        </div>
    </form>
</div>

<?php include('footer.php'); ?>

<!-- Add any necessary JavaScript scripts or links here -->

</body>
</html>
