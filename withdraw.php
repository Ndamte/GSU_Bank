<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>


<?php
// Start the session
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

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $withdraw_amount = $_POST["withdraw_amount"];

    // Assuming you have 'username' stored in session and 'balance' field in your 'users' table
    $username = $_SESSION["username"];

    // First, fetch the current balance from the database
    $sql = "SELECT balance FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $current_balance = $user['balance'];

    // Check if the balance is enough
    if($current_balance < $withdraw_amount) {
        echo "Insufficient balance.";
    } else {
        // Perform the withdrawal operation
        $new_balance = $current_balance - $withdraw_amount;

        // Update the balance in the database
        $sql = "UPDATE users SET balance = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $new_balance, $username);
        $stmt->execute();

        echo "Withdrawal successful. Your new balance is: $new_balance";
    }

    $stmt->close();
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Withdraw Amount: <input type="number" step="0.01" name="withdraw_amount" required>
    <br>
    <input type="submit" name="submit" value="Withdraw">
</form>
</body>
</html>
