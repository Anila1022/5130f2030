<?php
require 'db.php'; // Include database connection

session_start(); 

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginUsername'])) {
    $username = $conn->real_escape_string($_POST['loginUsername']);
    $password = $conn->real_escape_string($_POST['loginPassword']);

    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute and store result
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($id, $hashed_password);
        // Fetch the result
        if ($stmt->fetch()) {
            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;

                // Redirect to welcome page
                header("Location: welcome.php");
                exit;
            } else {
                $error_message = "Incorrect password.";
            }
        }
    } else {
        $error_message = "Incorrect username.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <?php
    if (!empty($error_message)) {
        echo '<p>' . $error_message . '</p>';
    }
    ?>
</body>
</html>
