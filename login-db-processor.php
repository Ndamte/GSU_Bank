<?php

 session_start();

 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "qma5"; // Corrected database name
 
 // Connect to MYSQL Server
 $conn = new mysqli($servername, $username, $password, $dbname);
 
 // Check the connection
 if ($conn->connect_error) {
     echo "could not connect to server \n";
     die("Connection failed: " . $conn->connect_error);
 } else {
     echo "Connection established!" . "<br>";
 }
 


// Process the form data

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
   
// Get the username from the session


// Prepare the query that selects the row with the specified username and password
$query = "SELECT * FROM accounts WHERE username = ? AND password = ?";


// Prepare the statement
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

// Bind the username and password to the statement
$stmt->bind_param("ss", $username, $password);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if a row was returned
if ($result->num_rows > 0) {
    header("Location: bankAppfunc.php");
    exit;
} else {
    $_SESSION["error"] = "Incorrect username or password";
    header("Location: login.php");
    exit;
}

// Close the statement 
$stmt->close();

// Close the database connection
$conn->close();

?>