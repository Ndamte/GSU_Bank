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
 

  <?php

$username = $_SESSION["username"]; // Replace with the actual username
date_default_timezone_set('America/New_York');
$currentMonth = date('Y-m');

// Query for deposits
$query = "SELECT SUM(amount) AS total_deposit FROM transactions WHERE username = ? AND description = 'deposit' AND DATE_FORMAT(date, '%Y-%m') = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalDeposit = $row['total_deposit'] ?? 0;

// Query for withdrawals
$query = "SELECT SUM(amount) AS total_withdrawal FROM transactions WHERE username = ? AND description = 'withdrawal' AND DATE_FORMAT(date, '%Y-%m') = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalWithdrawal = $row['total_withdrawal'] ?? 0;

// Calculate the total amount of transactions
$totalAmount = $totalDeposit + $totalWithdrawal;

if($totalAmount > 0) {
    $depositPercent = ($totalDeposit / $totalAmount) * 100;
    $withdrawalPercent = ($totalWithdrawal / $totalAmount) * 100;
    echo "<table style='border: none'>";
    echo "<tr>";
    

    echo "<td style='border: none;padding: 5px 20px;'>". "Total deposit: $totalDeposit (" . round($depositPercent, 2) . "% of total transactions)\n". "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='border: none;padding: 5px 20px;'>"."Total withdrawal: $totalWithdrawal (" . round($withdrawalPercent, 2) . "% of total transactions)\n". "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "No transactions this month\n";
}

$conn->close();
?>

  </div>

  </div>

 
</body>
</html>