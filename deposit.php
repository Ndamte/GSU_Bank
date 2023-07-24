<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>


  <?php
// Use session_start() to access the session variables
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bankapp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the current user's id and balance
// Assume that the user id is stored in the $_SESSION['user_id'] when user logs in
$user_id = $_SESSION['user_id'];

$sql = "SELECT balance FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // "i" indicates that user_id is an integer
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
$balance = $row['balance'];

// Get the deposit amount from the form
$depositAmount = $_POST['depositAmount'];

// Update the user's balance
$newBalance = $balance + $depositAmount;

$sql = "UPDATE users SET balance = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $newBalance, $user_id); // "d" indicates that newBalance is a double, "i" indicates that user_id is an integer
$stmt->execute();

echo "Deposit successful. Your new balance is " . $newBalance;

$stmt->close();
$conn->close();
?>
  <form action="deposit.php" method="post">
    <label for="depositAmount">Enter the amount to deposit:</label>
    <input type="number" id="depositAmount" name="depositAmount" required>
    <button type="submit">Deposit</button>
</form>
</body>
