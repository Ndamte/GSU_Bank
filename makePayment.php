<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qma5";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Check card details (you would typically validate this)
        $_SESSION['card_valid'] = true;
        header('Location: makePayment.php'); // Redirect to refresh
        exit();
    } elseif (isset($_POST['make_payment']) && isset($_SESSION['card_valid'])) {
        $paymentType = $_POST['paymentType'];
        $paymentAmount = $_POST['paymentAmount'];

        // Find the user's current balance
        $sql_balance = "SELECT balance FROM accounts WHERE username=?";
        $stmt_balance = $conn->prepare($sql_balance);
        $stmt_balance->bind_param("s", $_SESSION['username']);
        $stmt_balance->execute();
        $result_balance = $stmt_balance->get_result();
        $row_balance = $result_balance->fetch_assoc();
        $currentBalance = $row_balance['balance'];

        // Deduct payment amount from balance
        $newBalance = $currentBalance - $paymentAmount;

        // Update balance in database
        $sql_update_balance = "UPDATE accounts SET balance=? WHERE username=?";
        $stmt_update_balance = $conn->prepare($sql_update_balance);
        $stmt_update_balance->bind_param("ds", $newBalance, $_SESSION['username']);
        $stmt_update_balance->execute();

        $_SESSION['message'] = "Your $paymentType payment was successful!";
        header('Location: bankAppfunc.php');
        exit();
    }
}

if (!isset($_SESSION['card_valid'])) {
    // Show the login form if card details are not validated
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>
  <form method="post" action="">
    <label for="cardNumber">Card Number:</label><br>
    <input type="text" id="cardNumber" name="cardNumber"><br>
    <label for="expiryDate">Expiry Date:</label><br>
    <input type="text" id="expiryDate" name="expiryDate"><br>
    <label for="securityCode">Security Code:</label><br>
    <input type="text" id="securityCode" name="securityCode"><br>
    <input type="submit" name="login" value="Login">
  </form>
</body>
</html>
<?php
} else {
    // Show the payment form if card details are validated
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>
  <form method="post" action="">
    <label for="paymentType">Type of payment:</label><br>
    <select id="paymentType" name="paymentType">
      <option value="rent">Rent payment</option>
      <option value="car">Car payment</option>
      <option value="electric">Electric payment</option>
    </select><br>
    <label for="paymentAmount">Amount:</label><br>
    <input type="text" id="paymentAmount" name="paymentAmount"><br>
    <input type="submit" name="make_payment" value="Make Payment">
  </form>
</body>
</html>
<?php
}
?>
