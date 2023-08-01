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
          Deposit
       </div>

       <?php
       

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the amount is set
        if(isset($_POST['amount'])  && $_POST['amount'] > 0) {
            // Amount to add to the balance
            $amountToAdd = $_POST['amount'];
    
            // The username of the account to update is stored in the session
            $usernameToUpdate = $_SESSION['username'];
    
            // Check if user exists
            $check_user = $conn->prepare("SELECT username FROM account_information WHERE username = ?");
            $check_user->bind_param("s", $usernameToUpdate);
            $check_user->execute();
            $result = $check_user->get_result();
    
            if ($result->num_rows == 0) {
                // The user does not exist, add to the table
                $insert_user = $conn->prepare("INSERT INTO account_information (username, balance, account_holder, account_type, mailing_address, phone_number, email_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
                // Default values for new users
                $default_account_holder = 'Account Holder Name';
                $default_account_type = 'Savings';
                $default_mailing_address = '1234 Street, City, State, Zip';
                $default_phone_number = '1234567890';
                $default_email_address = 'email@example.com';
    
                // Bind parameters
                $insert_user->bind_param("sssssss", $usernameToUpdate, $amountToAdd, $default_account_holder, $default_account_type, $default_mailing_address, $default_phone_number, $default_email_address);
    
                // Execute insert operation
                if($insert_user->execute()) {
                    // User was added successfully
                } else {
                    echo "Error inserting new user: " . $insert_user->error;
                    exit;
                }
            }
    
            // Create a prepared statement
            $stmt = $conn->prepare("UPDATE account_information SET balance = balance + ? WHERE username = ?");
        
            // Bind parameters
            $stmt->bind_param("ds", $amountToAdd, $usernameToUpdate);
    
            // Execute query
            if($stmt->execute()) {
                // Insert into transactions table
                $description = 'deposit';
                date_default_timezone_set('America/New_York');
                $transaction_date = date('Y-m-d'); // Current date
                $transaction_time = date('H:i:s'); // Current time
                $stmt = $conn->prepare("INSERT INTO transactions (username, amount, description, date, transaction_time) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sdsss", $usernameToUpdate, $amountToAdd, $description, $transaction_date, $transaction_time);
                if($stmt->execute()) {
                    // Successful insertion into transactions table
                    header("Location: balance.php");
                    exit;
                } else {
                    echo "Error updating transactions: " . $stmt->error;
                }
            } else {
                echo "Error updating balance: " . $stmt->error;
            }
        } else {
            echo "Invalid deposit amount";
        }
    }
    ?>
    <form action="deposit2.php" method="post">
           <label for="amount">Enter amount to deposit:</label><br>
           <input type="text" name="amount" id="amount"  required><br>
           <input type="submit" value="Submit">
           </form>
  </div>

  



  </div>

  </div>

  <script src="script.js"></script>
</body>
</html>