<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $website = $_POST['website'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash new password

    $query = "UPDATE passwords SET website = $1, username = $2, password = $3 WHERE id = $4";
    $result = pg_query_params($conn, $query, [$website, $username, $password, $id]);

    if ($result) {
        echo "Password updated successfully!";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>
