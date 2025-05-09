<?php
$host = 'localhost';
$dbname = 'motus';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer une table si elle n'existe pas
    $pdo->exec("CREATE TABLE IF NOT EXISTS word (
        id INT AUTO_INCREMENT PRIMARY KEY,
        word VARCHAR(255) NOT NULL,
        attempts INT NOT NULL,
        player_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>