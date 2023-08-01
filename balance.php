<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>

<?php


// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gsu_bank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table
$sql ="CREATE TABLE IF NOT EXISTS account_information (
    username VARCHAR(50) NOT NULL,
    balance VARCHAR(20) NOT NULL,
    account_holder VARCHAR(100) NOT NULL,
    account_type VARCHAR(50) NOT NULL,
    mailing_address VARCHAR(200) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email_address VARCHAR(100) NOT NULL,
   
    PRIMARY KEY (username)
  )";




if ($conn->query($sql) === TRUE) {
   
} else {
    echo "Error creating table: " . $conn->error;
}


?>
  <div class="main">
  <div class="bankingApp ">
    <div class="bank_img"> <img src="bank.jpg"> </img> </div>

    <div class="balance common">
      <a href="balance.php">Account Balance</a>
      <p id="balanceDisplay"></p>
    </div>

    <div class="deposit common">
    <a href="deposit2.php">Make a Deposit</a>
      
    </div>

    <div class="withdraw common">
    
      <a href="withdrawal.php"> Withdraw Money</a> 
    </div>

    <div class="transfer common">
    <a href="transfer2.php"> Make a Transfer</a>
    </div>

    <div class="payment common">
    <a href="spending-analyzer.php"> Cash Flow Analysis</a>
    </div>

    <div class="history common">
    <a href="transaction-history2.php"> Transaction History</a>
    </div>
  </div>
  <div class="lower_body">
  <div class="acctProfile">

       <div class="profile_header"> 
        Account Balance
       </div>

       <?php
        $sql = "SELECT * FROM account_information WHERE username='".$_SESSION['username']."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<label>Your account balance is $" . $row['balance'] . "</label><br>";
      
            }
        } else {
            echo "No account information found";
        }
    ?>

  </div>

  



  </div>

  </div>

  <script src="script.js"></script>
</body>
</html>