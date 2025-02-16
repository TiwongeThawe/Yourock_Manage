<?php
require_once "/config.php";

$query = "SELECT id, website, username FROM passwords";
$result = pg_query($conn, $query);

$passwords = [];

while ($row = pg_fetch_assoc($result)) {
    $passwords[] = $row;
}

echo json_encode($passwords);
?>
