<?php
require 'config.php';
require 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId("527366567353-46bc5saknnp9fjo3cee3m4nhchgj3k9h.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("https://your-app.onrender.com/google_callback.php");

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token);

$oauth = new Google_Service_Oauth2($client);
$userData = $oauth->userinfo->get();

$email = $userData->email;
$name = $userData->name;
$google_id = $userData->id;

$query = "SELECT * FROM users WHERE email = :email";
$stmt = $conn->prepare($query);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $query = "INSERT INTO users (name, email, google_id) VALUES (:name, :email, :google_id)";
    $stmt = $conn->prepare($query);
    $stmt->execute(['name' => $name, 'email' => $email, 'google_id' => $google_id]);

    $_SESSION['user_id'] = $conn->lastInsertId();
} else {
    $_SESSION['user_id'] = $user['id'];
}

header("Location: dashboard.php");
exit;
?>
