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
$sql = "CREATE TABLE IF NOT EXISTS account_information (
  username VARCHAR(50) NOT NULL,
  balance VARCHAR(50) NOT NULL,
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
        Account Information
       </div>

       <?php
        $sql = "SELECT * FROM account_information WHERE username='".$_SESSION['username']."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<label>username: " . $row['username'] . "</label><br>";
                echo "<label>account holder: " . $row['account_holder'] . "</label><br>";
                echo "<label>account type: " . $row['account_type'] . "</label><br>";
                echo "<label>mailing address: " . $row['mailing_address'] . "</label><br>";
                echo "<label>phone number: " . $row['phone_number'] . "</label><br>";
                echo "<label>email address: " . $row['email_address'] . "</label><br>";
               
            }
        } else {
            echo "No account information found";
        }
    ?>

  </div>

  <div class="recent">  
    <div class="activity_header"> 
     Recent Activity
     </div>
     <div class="activity_header spacing"> 
     Amount Description Date Time
     </div>
     <div class="desc_content spacing_content">

     <?php

    $sql = "CREATE TABLE IF NOT EXISTS transactions (
            username VARCHAR(50) NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            description TEXT,
            date DATE NOT NULL,
            transaction_time TIME NOT NULL,
            FOREIGN KEY (username) REFERENCES account_information(username)
          )";

          if ($conn->query($sql) === TRUE) {
               
          } else {
              echo "Error creating table: " . $conn->error;
          }
          $sql = "SELECT * FROM transactions WHERE username='" . $_SESSION['username'] . "' AND date = CURDATE() ORDER BY transaction_time DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  echo "<table style='border: none'>";
  while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td style='border: none;padding: 5px 20px;'>" . $row['amount'] . "</td>";
      echo "<td style='border: none;padding: 5px 20px;'>" . $row['description'] . "</td>";
      echo "<td style='border: none;padding: 5px 20px;'>" . $row['date'] . "</td>";
      echo "<td style='border: none;padding: 5px 20px;'>" . $row['transaction_time'] . "</td>";
      echo "</tr>";
  }
  echo "</table>";
 } else {
    echo "No transactions found for today.";
}
             
            $conn->close();
        ?>

    </div>

  </div> 

  </div>

  </div>

  
</body>
</html>