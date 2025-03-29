<?php
// Database configuration
$host = 'adrizgroup.com';
$dbname = 'u215165343_adrizdb';
$username = 'u215165343_adrizadmin';
$password = 'adriz@Admin123';

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // User details to insert
    $username = "admin"; // Change this to your desired username
    $password = "adriz@Admin123"; // Change this to your desired password
    
    // Hash the password using PHP's password_hash function
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    
    // Execute with parameters
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashed_password
    ]);
    
    echo "User added successfully!";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>