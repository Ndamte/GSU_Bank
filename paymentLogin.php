<!-- This is paymentLogin.php -->
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>
  <form method="post" action="makePayment.php">
    <label for="cardNumber">Card Number:</label><br>
    <input type="text" id="cardNumber" name="cardNumber"><br>
    <label for="expiryDate">Expiry Date:</label><br>
    <input type="text" id="expiryDate" name="expiryDate"><br>
    <label for="securityCode">Security Code:</label><br>
    <input type="text" id="securityCode" name="securityCode"><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
