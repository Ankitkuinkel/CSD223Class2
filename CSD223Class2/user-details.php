<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

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

// Fetch user details
$user_id = $_SESSION['user_id'];
$query_details = "
    SELECT u.email, u.account_number, a.withdrawal, a.deposit, a.balance
    FROM tbl_user u
    LEFT JOIN tbl_account a ON u.user_id = a.user_id
    WHERE u.id=?";
$stmt_details = $conn->prepare($query_details);
$stmt_details->bind_param("i", $user_id);
$stmt_details->execute();

if ($stmt_details->error) {
    echo "Error in details query: " . $stmt_details->error;
}

$result_details = $stmt_details->get_result();

// Check if details exist
if ($result_details->num_rows > 0) {
    $details = $result_details->fetch_assoc();
} else {
    // Redirect to an error page if no details are found
    header('Location: error.php');
    exit();
}

$stmt_details->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Add any necessary CSS stylesheets or links here -->
    <style>
        table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<!-- Display user details -->
<h1>User Details</h1>
<?php if (isset($details) && $details !== null) : ?>
    <table>
        <tr>
            <th>User Information</th>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $details['email']; ?></td>
        </tr>
        <tr>
            <td>Account Number</td>
            <td><?php echo isset($details['account_number']) ? $details['account_number'] : 'N/A'; ?></td>
        </tr>
        <tr>
            <td>Withdrawal</td>
            <td><?php echo isset($details['withdrawal']) ? $details['withdrawal'] : 'N/A'; ?></td>
        </tr>
        <tr>
            <td>Deposit</td>
            <td><?php echo isset($details['deposit']) ? $details['deposit'] : 'N/A'; ?></td>
        </tr>
        <tr>
            <td>Balance</td>
            <td><?php echo isset($details['balance']) ? $details['balance'] : 'N/A'; ?></td>
        </tr>
    </table>
<?php else : ?>
    <p>No details found.</p>
<?php endif; ?>

<!-- Add any necessary JavaScript scripts or links here -->

</body>
</html>
