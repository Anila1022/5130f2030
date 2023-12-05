<?php
require 'db.php'; // Include database connection

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select all data from the "users" table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Phone</th><th>Full Name</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["full_name"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

// Close the database connection
$conn->close();
?>
