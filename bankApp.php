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
    </div>

    <div class="transfer common">
      <p>Make a Transfer</p>
    </div>

    <div class="payment common">
      <p>Make a Payment</p>
    </div>

    <div class="history common">
      <p>Transaction History</p>
      <ul id="transactionHistory"></ul>
    </div>
  </div>
  <div class="lower_body">
  <div class="acctProfile">
       <div class="profile_header"> 
        Account Information
       </div>
       <?php
       $sql = "SELECT * FROM accounts WHERE username='".$_SESSION['username']."'";
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
               echo "<label>account holder: " . $row['account_holder'] . "</label><br>";
               echo "<label>mailing address: " . $row['mailing_address'] . "</label><br>";
               echo "<label>phone number: " . $row['phone_number'] . "</label><br>";
               echo "<label>email address: " . $row['email_address'] . "</label><br>";
               echo "<label>account number: " . $row['account_number'] . "</label><br>";
               echo "<label>routing number: " . $row['routing_number'] . "</label><br>";
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
     <div class="desc_content">
      <?php
            $sql = "SELECT * FROM activities WHERE username='".$_SESSION['username']."' ORDER BY activity_date DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='description'><label>description: " . $row['description'] . "</label></div>";
                    echo "<div class='amount'><label>amount: " . $row['amount'] . "</label></div>";
                }
            } else {
                echo "No recent activity";
            }
        ?>

    </div>

  </div> 

  </div>

  </div>

  <script src="script.js"></script>
</body>
</html>