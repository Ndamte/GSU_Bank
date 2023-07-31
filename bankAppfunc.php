<?php
// Start the session
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "qma5"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>
  <div class="main">
  <div class="bankingApp ">
    <div class="bank_img"> <img src="bank.jpg"> </img> </div>

    <div class="balance common">
      <p>Account Balance</p>
      <p id="balanceDisplay"></p>
    </div>

    <div class="deposit common">
      <p>Make a Deposit</p>
    </div>

    <div class="withdraw common">
      <p>Withdraw Money</p>
      <a href="withdraw.php"> </a> 
    </div>

    <div class="transfer common">
      <p>Make a Transfer</p>
    </div>

    <div class="payment common">
      <p><a href="makePayment.php">Make a Payment</a></p>
    </div>

  </div>
  <div class="lower_body">
  <div class="acctProfile">

       <div class="profile_header"> 
        Account Information
       </div>

       <?php
       $sql = "SELECT * FROM accounts WHERE username = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("s", $_SESSION['username']);
       $stmt->execute();
       $result = $stmt->get_result();
       
       if ($result->num_rows > 0) {
           while ($row = $result->fetch_assoc()) {
               echo "Username: " . $row['username'] . "<br>";
               echo "First Name: " . $row['first_name'] . "<br>";
               echo "Last Name: " . $row['last_name'] . "<br>";
               echo "Address: " . $row['address'] . "<br>";
               echo "Balance: $" . $row['balance'] . "<br>";
               echo "Email: " . $row['email'] . "<br>";
               echo "Phone: " . $row['phone'] . "<br>";
           }
       } else {
           echo "No account information found";
       }
    ?>

  </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
