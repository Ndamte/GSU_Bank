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
 

  <div class="recent">  
    <div class="activity_header"> 
    Transaction History
     </div>
     <div class="activity_header spacing"> 
    Amount Description Date Time
     </div>
     <div class="desc_content spacing_content">

     <?php

      if(isset($_SESSION['username'])) {
         $sql = "SELECT * FROM transactions WHERE username='".$_SESSION['username']."' AND date = CURDATE() ORDER BY transaction_time DESC";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            echo "<table style='border: none'>";
              while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='border: none;padding: 5px 20px;'>" . $row['amount'] . "</td>";
                echo "<td style='border: none;padding: 5px 20px;'>" . $row['description'] . "</td>";
                echo "<td style='border: none;padding: 5px 20px;'>" . $row['date'] . "</td>";
                echo "<td style='border: none;padding: 5px 20px;'>" . $row['transaction_time'] . "</td>";
                //  echo "<label style='display: block;'> " . $row['amount'] . '&nbsp;'. $row['description'] . '&nbsp;'. $row['date'] . '&nbsp;'. "</label><br>";
                 
                  echo "</tr>";
              }

              echo "</table>";
          } else {
              echo "No transactions found";
          }

        }else {
            // Handle the case where $_SESSION['username'] is not set.
            echo "Username is not set in the session";
        }
      
        
        
        
        
        
             
            $conn->close();
        ?>

    </div>

  </div> 

  </div>

  </div>

 
</body>
</html>