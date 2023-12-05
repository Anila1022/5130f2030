<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection here
    include 'db.php'; 

    $feedback = $_POST['feedback'];

    // SQL to insert feedback
    $stmt = $conn->prepare("INSERT INTO feedback (content) VALUES (?)");
    $stmt->bind_param("s", $feedback);

    if ($stmt->execute()) {
        echo "Feedback submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
