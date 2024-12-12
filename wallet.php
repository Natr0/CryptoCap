<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

require 'includes/db_connection.php';

$user_id = $_SESSION['user_id'];

// Calculate total portfolio balance
$query = "SELECT 
      SUM(CASE WHEN transaction_type = 'deposit' THEN amount ELSE 0 END) -
      SUM(CASE WHEN transaction_type = 'withdraw' THEN amount ELSE 0 END) AS total_balance
     FROM transactions
     WHERE user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_balance = $row['total_balance'] ?? 0; // Set to 0 if no result

$stmt->close();

// Fetch purchased coins
$coins_query = "SELECT id, coin_name, coin_symbol, amount, purchase_price, purchase_date FROM purchased_coins WHERE user_id = ?";
$coins_stmt = $connection->prepare($coins_query);
$coins_stmt->bind_param("i", $user_id);
$coins_stmt->execute();
$coins_result = $coins_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wallet - CryptoCap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .wallet-container {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
    }
    .card-custom {
      border: 1px solid #e1e1e1;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .balance-section {
      font-size: 2em;
      font-weight: bold;
    }
    .btn-wallet {
      width: 100%;
    }
    .table-coins {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>
  <div class="container mt-4">
    <div class="wallet-container">
      <h2>My Wallet</h2>
      
      <!-- Total Portfolio Section -->
      <div class="card-custom">
        <div class="row">
          <div class="col-md-8">
            <p>Total Portfolio</p>
            <div class="balance-section">€<?php echo number_format($total_balance, 2); ?></div>
          </div>
          <div class="col-md-4 text-end">
            <button class="btn btn-link">1D</button>
            <button class="btn btn-link">7D</button>
            <button class="btn btn-link">30D</button>
            <button class="btn btn-link">1Y</button>
            <button class="btn btn-link">ALL</button>
          </div>
        </div>
        <hr>
        <canvas id="portfolioChart" height="80"></canvas>
      </div>

      <!-- Table of Purchased Coins with Sell button -->
      <div class="table-coins">
        <h3>Purchased Coins</h3>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Coin Name</th>
              <th>Symbol</th>
              <th>Amount</th>
              <th>Purchase Price (€)</th>
              <th>Purchase Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($coin = $coins_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($coin['coin_name']); ?></td>
                <td><?php echo htmlspecialchars($coin['coin_symbol']); ?></td>
                <td><?php echo number_format($coin['amount'], 8); ?></td>
                <td>€<?php echo number_format($coin['purchase_price'], 2); ?></td>
                <td><?php echo $coin['purchase_date']; ?></td>
                <td>
                  <button class="btn btn-danger" onclick="showSellModal('<?php echo $coin['id']; ?>', '<?php echo $coin['coin_name']; ?>', '<?php echo $coin['amount']; ?>')">Sell</button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Sell Modal -->
  <div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sellModalLabel">Sell Coin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="process_sale.php" method="POST">
            <input type="hidden" id="sellCoinId" name="coin_id">
            <input type="hidden" id="currentAmount" name="current_amount">
            <div class="mb-3">
              <label for="sellAmount" class="form-label">Amount to Sell</label>
              <input type="number" step="0.0001" class="form-control" id="sellAmount" name="sell_amount" placeholder="Amount of coins to sell" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">Sell</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Chart.js 
    const ctx = document.getElementById('portfolioChart').getContext('2d');
    const portfolioChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['18:00', '3 NOV', '06:00', '12:00'],
        datasets: [{
          label: 'Portfolio Value',
          data: [0, 0, 0, 0],
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          fill: true
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            display: true
          },
          y: {
            display: true
          }
        }
      }
    });

    // Show Sell Modal and set data
    function showSellModal(coinId, coinName, currentAmount) {
      $('#sellModalLabel').text(`Sell ${coinName}`);
      $('#sellCoinId').val(coinId);
      $('#currentAmount').val(currentAmount);
      $('#sellModal').modal('show');
    }
  </script>
</body>
</html>
