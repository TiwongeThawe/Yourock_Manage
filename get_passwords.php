<?php
require_once "config.php"; // Ensure database connection is established

try {
    $query = "SELECT id, website, username, password FROM passwords";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($passwords);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
}
?>
