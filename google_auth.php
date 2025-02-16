<?php
require 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId("527366567353-46bc5saknnp9fjo3cee3m4nhchgj3k9h.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("https://your-app.onrender.com/google_callback.php");
$client->addScope("email");
$client->addScope("profile");

header("Location: " . $client->createAuthUrl());
exit;
?>
