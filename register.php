<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $conn->prepare($query);
    if ($stmt->execute(['name' => $name, 'email' => $email, 'password' => $password])) {

      //Get the newly registered user's ID
      $user_id = $conn->lastInsertID();

      //Session info
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $name;
      $_SESSION['user_email'] = $email;

      //Dashboard redir
      header("Location: dashboard.php");
      exit();
    } else {
      echo "Error:Registration failed.";
    }
  

    echo "Registered successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouRock! Signup</title>
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
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="code9.onrender.com">Code9</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header">
        <h3>Create a New Account</h3>
      </div>
      <div class="card-body">
        <form id='reg' method="post" action="register.php">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Sign Up</button>
          </div>
        </form>
        <p class="mt-3 text-center">
          Already have an account? <a href="/login">Log in here</a>.
        </p>
      </div>
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
</body>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
