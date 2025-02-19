<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouRock! Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ url_for('static', filename='css/style.css') }}">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>

    .footer .developer-logo {
            opacity: 0.5;
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 100px;
        }
        
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">YouRock Password Manager</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="code9.onrender.com">Code9</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Sign Up</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow p-4">
      <h3 class="text-center mb-4">Login</h3>
      <form id="login" action="login.php" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <hr>
        <a href="google_auth.php" class="btn btn-outline-danger w-100">
          <i class="fab fa-google"></i> Login with Google
        </a>
      </form>
      <p class="mt-3 text-center">
        Don't have an account? <a href="/signup">Sign up here</a>.
      </p>      
    </div>
  </div>
</div>

<footer class="footer text-center">
  <div class="container">
    <p>&copy; 2024 Code9ZM | All Rights Reserved</p>
    <div>
        <a href="#" class="text-light mx-2"><i class="fab fa-facebook"></i></a>
        <a href="#" class="text-light mx-2"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-light mx-2"><i class="fab fa-linkedin"></i></a>
    </div>
      <img src="dev-logo.png" alt="Developer Logo" class="developer-logo">
  </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>