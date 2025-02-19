<?php
require 'config.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $website = $_POST['website'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($website && $username && $password) {
        // encrypt password before storing
        $encryptedPassword = openssl_encrypt($password, "aes-256-cbc", $key, 0, $iv);
        $ivHex = bin2hex($iv); // Store IV for decryption

        
        // Insert into database
        $query = "INSERT INTO passwords (website, username, password) VALUES (:website, :username, :password)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['website' => $website, 'username' => $username, 'password' => $encryptedPassword]);
        
        echo "Password saved successfully!";
    } else {
        echo "All fields are required!";
    }
} else {
    echo "Invalid request!";
}
?>
