<?php

 session_start();

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "gsu_bank"; 

// Connect to MYSQL Server
$conn = new mysqli($servername, $username, $password, $databaseName);

// Check the connection
if ($conn->connect_error) {
    echo "could not connect to server \n";
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connection established!" . "<br>";
}


// Process the form data

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
   
// Get the username from the session


// Prepare a query that selects the row with the specified username
$query = "SELECT * FROM users WHERE username = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind the username to the statement
$stmt->bind_param("s", $username);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Check if a row was returned
if ($result->num_rows > 0) {
 // Close the statement 
 $stmt->close();
    
 // Check if user exists in account_information table
 $query = "SELECT * FROM account_information WHERE username = ?";
 $stmt = $conn->prepare($query);
 $stmt->bind_param("s", $username);
 $stmt->execute();
 $result = $stmt->get_result();
 if ($result->num_rows == 0) {
     // User doesn't exist, so insert into account_information with dummy values
     $stmt->close();
     $insert_query = "INSERT INTO account_information (username, balance, account_holder, account_type, mailing_address, phone_number, email_address) VALUES (?, '0', 'John Doe', 'Savings', '123 Buford Dr, Buford, GA, 30033', '123-456-7890', 'gsu@gmail.com')";
     $insert_stmt = $conn->prepare($insert_query);
     $insert_stmt->bind_param("s", $username);
     if (!$insert_stmt->execute()) {
         echo "Error: " . $insert_stmt->error;
     }
     $insert_stmt->close();
 } else {
     $stmt->close();
 }
 
 // Redirect to bankAppfunc.php
 header("Location: bankAppfunc.php");
 exit;
} else {
 $_SESSION["error"] = "Incorrect username or password";
 header("Location: login.php");
 exit;
}

// Close the database connection
$conn->close();
?>