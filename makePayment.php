<!-- This is makePayment.php -->
<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check card details
  $cardNumber = $_POST['cardNumber'];
  $expiryDate = $_POST['expiryDate'];
  $securityCode = $_POST['securityCode'];

  $_SESSION['card_valid'] = true;
}

if (!isset($_SESSION['card_valid'])) {
  echo "Please login with your card details first.";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>
  <form method="post" action="processPayment.php">
    <label for="paymentType">Type of payment:</label><br>
    <select id="paymentType" name="paymentType">
      <option value="rent">Rent payment</option>
      <option value="car">Car payment</option>
      <option value="electric">Electric payment</option>
    </select><br>
    <input type="submit" value="Make Payment">
  </form>
</body>
</html>
