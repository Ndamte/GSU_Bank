<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>

    <?php
    // Start the session
    session_start();
    
    // Include database connection file
    include 'db_connect.php';
    
    // Check if form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $transfer_amount = $_POST["transfer_amount"];
        $recipient_username = $_POST["recipient_username"];
    
        // Assuming you have 'username' stored in session and 'balance' field in your 'users' table
        $username = $_SESSION["username"];
    
        // First, fetch the current balance from the database
        $sql = "SELECT balance FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $current_balance = $user['balance'];
    
        // Check if the balance is enough
        if($current_balance < $transfer_amount) {
            echo "Insufficient balance.";
        } else {
            // Perform the withdrawal operation
            $new_balance = $current_balance - $transfer_amount;
    
            // Update the balance in the database for the sender
            $sql = "UPDATE users SET balance = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ds", $new_balance, $username);
            $stmt->execute();
    
            // Now, add the transferred amount to the recipient's balance
            // Fetch the recipient's balance
            $sql = "SELECT balance FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $recipient_username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $recipient_current_balance = $user['balance'];
    
            $recipient_new_balance = $recipient_current_balance + $transfer_amount;
    
            // Update the recipient's balance in the database
            $sql = "UPDATE users SET balance = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ds", $recipient_new_balance, $recipient_username);
            $stmt->execute();
    
            echo "Transfer successful. Your new balance is: $new_balance";
        }
    
        $stmt->close();
    }
    
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Recipient Username: <input type="text" name="recipient_username" required>
        <br>
        Transfer Amount: <input type="number" step="0.01" name="transfer_amount" required>
        <br>
        <input type="submit" name="submit" value="Transfer">
    </form>


</body>
</html>
