<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CryptoCap - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
        .hero-section {
      background-image: url('assets/img/background.jpg');
      background-size: cover;
      background-position: center;
      color: #fff;
      padding: 100px 0;
        text-align: center;
      box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.5);
    }
    .hero-section h1 {
      font-size: 3em;
        font-weight: bold;
      margin-bottom: 20px;
    }
    .hero-section p {
         font-size: 1.2em;
      max-width: 600px;
      margin: 0 auto;
    }
    .section-title {
        text-align: center;
      margin-top: 50px;
      margin-bottom: 20px;
      font-weight: bold;
    }
      .card-custom {
       border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       border-radius: 10px;
      transition: transform 0.3s;
    }
    .card-custom:hover {
      transform: translateY(-10px);
    }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <!-- Hero Section -->
  <div class="hero-section">
    <h1>Welcome to CryptoCap</h1>
    <p>Your ultimate destination for the latest cryptocurrency data, prices, and news.</p>
    <a href="register.php" class="btn btn-primary btn-lg mt-3"><i class="fas fa-user-plus me-2"></i>Join Us Today</a>
  </div>

  <!-- About Section -->
  <div class="container mt-5">
    <h2 class="section-title">Why Choose CryptoCap?</h2>
    <p class="text-center text-muted">Discover why CryptoCap is the preferred choice for crypto enthusiasts worldwide.</p>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card card-custom p-4 text-center">
          <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
          <h5>Real-Time Market Data</h5>
          <p>Access up-to-date data on popular cryptocurrencies and stay ahead in the market.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-custom p-4 text-center">
          <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
          <h5>Secure & Reliable</h5>
          <p>We prioritize your data security, ensuring a safe platform for all your cryptocurrency needs.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-custom p-4 text-center">
          <i class="fas fa-newspaper fa-3x text-primary mb-3"></i>
          <h5>Latest Crypto News</h5>
          <p>Stay informed with the latest news and trends in the world of cryptocurrency.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Call-to-Action Section -->
  <div class="container mt-5 text-center">
    <h2 class="section-title">Ready to Dive In?</h2>
    <p class="text-muted">Join thousands of users who trust CryptoCap to keep them informed and secure in the world of crypto.</p>
    <a href="register.php" class="btn btn-success btn-lg"><i class="fas fa-arrow-right me-2"></i>Get Started Now</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/scripts.js"></script>
</body>
</html>
