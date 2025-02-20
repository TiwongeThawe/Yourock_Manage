<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'], $_POST['website'], $_POST['username'], $_POST['password']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        $website = $_POST['website'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash new password

        try {
            $query = "UPDATE passwords SET website = :website, username = :username, password = :password WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':website', $website, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Password updated successfully!";
            } else {
                echo "Error: Unable to update password.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid input provided.";
    }
}
?>

