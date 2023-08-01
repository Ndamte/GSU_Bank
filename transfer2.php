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
         Withdraw
       </div>

       <?php
       

       $fromUsername = $_SESSION['username'];

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the amount is set and the transfer_to username is set
        if(isset($_POST['amount'], $_POST['transfer_to']) && $_POST['amount'] > 0) {
            // Amount to transfer
            $amountToTransfer = $_POST['amount'];
            // Username to transfer the amount to
            $toUsername = $_POST['transfer_to'];
    
            // Fetch sender's balance
            $result = $conn->query("SELECT balance FROM account_information WHERE username = '$fromUsername'");
            $sender = $result->fetch_assoc();
    
            // Check if sender has enough balance to make the transfer
            if($sender['balance'] >= $amountToTransfer) {
                // Deduct the amount from sender's balance
                $stmt1 = $conn->prepare("UPDATE account_information SET balance = balance - ? WHERE username = ?");
                $stmt1->bind_param("ds", $amountToTransfer, $fromUsername);
                $stmt1->execute();
    
                // Add the amount to recipient's balance
                $stmt2 = $conn->prepare("UPDATE account_information SET balance = balance + ? WHERE username = ?");
                $stmt2->bind_param("ds", $amountToTransfer, $toUsername);
                $stmt2->execute();
                
                // Insert into transactions table
                $description = 'transfer';
                date_default_timezone_set('America/New_York');
                $transaction_date = date('Y-m-d'); // Current date
                $transaction_time = date('H:i:s'); // Current time
                $stmt3 = $conn->prepare("INSERT INTO transactions (username, amount, description, date, transaction_time) VALUES (?, ?, ?, ?, ?)");
                $stmt3->bind_param("sdsss", $fromUsername, $amountToTransfer, $description, $transaction_date, $transaction_time);
                $stmt3->execute();
    
                // Redirect to balance.php
                header("Location: balance.php");
                exit;
            } else {
                echo "Insufficient balance for the transfer.";
            }
        } else {
            echo "Invalid input.";
        }
    }
    ?>
    <form action="transfer2.php" method="post">
    <label for="transfer_to">Transfer to:</label><br>
    <input type="text" id="transfer_to" name="transfer_to" required><br>
    <label for="amount">Amount:</label><br>
    <input type="text" id="amount" name="amount" required><br>
    <input type="submit" value="Submit">
    </form>
  </div>

  



  </div>

  </div>

  <script src="script.js"></script>
</body>
</html>