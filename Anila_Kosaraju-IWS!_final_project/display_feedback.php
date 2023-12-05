<?php
$host = '18.219.132.59';
$db = 'car_leasing';
$user = 'mahendra';
$pass = 'Vardhan2233';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT * FROM feedback";
$stmt = $pdo->query($sql);
echo "<table style='border-collapse: collapse; width: 100%;'><tr><th style='border: 1px solid black;'>ID</th><th style='border: 1px solid black;'>Content</th><th style='border: 1px solid black;'>Submitted At</th></tr>";
while ($row = $stmt->fetch()) {
    echo "<tr><td style='border: 1px solid black;'>".$row['id']."</td><td style='border: 1px solid black;'>".$row['content']."</td><td style='border: 1px solid black;'>".$row['submitted_at']."</td></tr>";
}
echo "</table>";
?>
