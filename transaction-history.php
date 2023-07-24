<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>

    <?php
    // Start the session
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bankapp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
    
    // Assuming you have 'username' stored in session
    $username = $_SESSION["username"];
    
    // Fetch the transactions from the database
    $sql = "SELECT sender, recipient, amount, timestamp FROM transactions WHERE sender = ? OR recipient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<h2>Transaction History</h2>";
    echo "<table>";
    echo "<tr><th>Sender</th><th>Recipient</th><th>Amount</th><th>Timestamp</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['sender']) . "</td>";
        echo "<td>" . htmlspecialchars($row['recipient']) . "</td>";
        echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
        echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    $stmt->close();
    ?>

</body>
</html>
