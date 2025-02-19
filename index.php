<?php
session_start(); // Start session to check if user is logged in

// Redirect logged-in users to the dashboard, otherwise to the registration page
if (isset($_SESSION['user_email'])) {
    header("Location: dashboard.php"); // Redirect to dashboard if logged in
} else {
    header("Location: login.php"); // Redirect to registration page if not logged in
}
exit(); // Ensure script stops execution after redirect
?>
