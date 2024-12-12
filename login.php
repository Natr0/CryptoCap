<?php
session_start(); 
require 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      header("Location: index.php");
      exit();
    } else {
      $error_message = "Incorrect username or password.";
    }
  } else {
    $error_message = "Incorrect username or password.";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - CryptoCap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .hero-section {
        background-image: url('assets/img/background.jpg');
      background-size: cover;
      background-position: center;
      color: #fff;
      padding: 60px 0;
      text-align: center;
      box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.6);
    }
    .hero-section h1 {
      font-size: 3em;
      font-weight: bold;
    }
    .login-form {
      background-color: #f8f9fa;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      margin: 20px auto;
    }
    .btn-primary {
      width: 100%;
    }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <!-- Hero Section -->
  <div class="hero-section">
    <h1>Login to CryptoCap</h1>
    <p>Access your wallet, track your portfolio, and stay updated with the latest cryptocurrency news.</p>
  </div>

  <!-- Login Form Section -->
  <div class="container mt-5">
    <div class="login-form">
      <h2 class="text-center mb-4">Welcome Back!</h2>
      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
      </form>
      <div class="text-center mt-3">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
