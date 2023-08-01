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



$tableName = 'users';
$table = "CREATE TABLE IF NOT EXISTS $tableName (
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL
);";

// Execute the query
if ($conn->query($table) === TRUE) {
    echo " users table created successfully." . "<br>";
} else {
    echo "Error creating table: " . $conn->error;
}


// Process the form data

    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $email = $_SESSION["email"];
   
    function isUserRegistered($username, $conn) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        
        // Bind parameters
        $stmt->bind_param("s", $username);
    
        // Execute the statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return true; // User exists
        }
    
        return false; // User does not exist
    }
    
    // Usage
    if (!isUserRegistered($username, $conn)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    
        // Bind parameters
        $stmt->bind_param("sss", $username, $password, $email);
    
        // Execute the statement
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $_SESSION["signin_error"] = "An error occurred while signing up.";
            header("Location: signup.php");
            exit;
        }
    } else {
        $_SESSION["signin_error"] = "Username already exists. Please choose another one.";
        header("Location: signup.php");
        exit;
    }
    



// Close the database connection

$conn->close();
?>