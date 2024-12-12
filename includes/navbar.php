

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <i class="fas fa-coins me-2"></i> <span style="font-weight: bold; font-size: 1.5em;">CryptoCap</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-light fw-bold" href="index.php"><i class="fas fa-home me-1"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-bold" href="crypto.php"><i class="fas fa-chart-line me-1"></i> Cryptocurrency Overview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-bold" href="exchanges.php"><i class="fas fa-exchange-alt me-1"></i> Exchanges</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light fw-bold" href="news.php"><i class="fas fa-newspaper me-1"></i> Crypto News</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="wallet.php"><i class="fas fa-wallet me-1"></i> Wallet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i> Log out</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="login.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="register.php"><i class="fas fa-user-plus me-1"></i> Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
