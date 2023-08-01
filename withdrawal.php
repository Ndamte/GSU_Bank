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
       

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the amount is set
        if(isset($_POST['amount'])  && $_POST['amount'] > 0) {
            // Amount to subtract from the balance
            $amountToSubtract = $_POST['amount'];
    
            // The username of the account to update is stored in the session
            $usernameToUpdate = $_SESSION['username'];
    
            // Start transaction
            $conn->begin_transaction();
    
            try {
                // Create a prepared statement
                $stmt = $conn->prepare("UPDATE account_information SET balance = balance - ? WHERE username = ?");
                // Bind parameters
                $stmt->bind_param("ds", $amountToSubtract, $usernameToUpdate);
                // Execute query
                $stmt->execute();
    
                // Log the transaction
                $description = "withdrawal";
                date_default_timezone_set('America/New_York');
                $transaction_date = date("Y-m-d");
                $transaction_time = date("H:i:s");
                $stmt = $conn->prepare("INSERT INTO transactions (username, amount, description, date, transaction_time) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sdsss", $usernameToUpdate, $amountToSubtract, $description, $transaction_date, $transaction_time);
                $stmt->execute();
    
                // Commit the transaction
                $conn->commit();
    
                header("Location: balance.php");
                exit;
            } catch (mysqli_sql_exception $exception) {
                $conn->rollback();
                echo "Error updating balance: " . $exception->getMessage();
            }
        } else {
            echo "Invalid withdrawal amount";
        }
    }
    ?>
    <form action="withdrawal.php" method="post">
           <label for="amount">Enter withdrawal amount:</label><br>
           <input type="text" name="amount" id="amount"  required><br>
           <input type="submit" value="Submit">
           </form>
  </div>

  



  </div>

  </div>

  <script src="script.js"></script>
</body>
</html>