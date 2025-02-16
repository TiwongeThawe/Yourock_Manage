<?php
require 'config.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $website = $_POST['website'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($website && $username && $password) {
        // Hash password before storing
        $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
        
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO passwords (website, username, password) VALUES (:website, :username, :password)");
        $stmt->execute(['website' => $website, 'username' => $username, 'password' => $hashed_password]);
        
        echo "Password saved successfully!";
    } else {
        echo "All fields are required!";
    }
} else {
    echo "Invalid request!";
}
?>
