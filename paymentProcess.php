<!-- This is processPayment.php -->
<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['card_valid'])) {
  $paymentType = $_POST['paymentType'];
  // In a real application, here you would process the payment, update the user's balance and store the transaction
  // In this academic project, we just create a success message
  $_SESSION['message'] = "Your $paymentType payment was successful!";
}

header('Location: bankApp.php'); 
exit();
?>
