<?php
require_once "config.php"; // Ensure database connection is established

$key = "your-secret-key"; // Same key as used in save_password.php


try {
    $query = "SELECT id, website, username, password, iv FROM passwords";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($passwords as &$pw) {
        $iv = hex2bin($pw["iv"]); // Convert IV back to binary
        $pw["password"] = openssl_decrypt($pw["password"], "aes-256-cbc", $key, 0, $iv);
    }
    
    echo json_encode($passwords);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
}
?>
