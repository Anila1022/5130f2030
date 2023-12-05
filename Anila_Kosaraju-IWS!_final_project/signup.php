<?php
require 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['signupUsername']);
    $password = $conn->real_escape_string($_POST['signupPassword']);
    $email = $conn->real_escape_string($_POST['signupEmail']);
    $phone = $conn->real_escape_string($_POST['signupPhone']);
    $fullName = $conn->real_escape_string($_POST['signupFullName']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, email, phone, full_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $phone, $fullName);

    // Execute and check for success
    if ($stmt->execute()) {
        header("Location: login.php"); 
        exit; 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
