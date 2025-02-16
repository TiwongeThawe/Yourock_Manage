<?php
require_once "/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $query = "DELETE FROM passwords WHERE id = $1";
    $result = pg_query_params($conn, $query, [$id]);

    if ($result) {
        echo "Password deleted successfully!";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
?>
