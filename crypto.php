<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>CryptoMania - Cryptocurrency Overview</title>
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
  .crypto-card {
   border: none;
   border-radius: 10px;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   padding: 20px;
   margin: 20px 0;
   transition: transform 0.3s;
   background-color: #f8f9fa;
  }
  .crypto-card:hover {
   transform: translateY(-10px);
  }
  .section-title {
   font-weight: bold;
   margin-top: 40px;
   text-align: center;
  }
  .modal-body canvas {
   margin-bottom: 20px;
  }
 </style>
</head>
<body>
 <?php include 'includes/navbar.php'; ?>

 <!-- Hero Section -->
 <div class="hero-section">
  <h1>Explore Cryptocurrencies</h1>
  <p>Track the latest prices, trends, and data for top cryptocurrencies.</p>
 </div>

 <!-- Cryptocurrency Section -->
 <div class="container mt-5">
  <h2 class="section-title">Top Cryptocurrencies</h2>
  <div id="crypto-list" class="row"></div>
 </div>

 <!-- Modal for coin details and purchase -->
 <div class="modal fade" id="coinModal" tabindex="-1" aria-labelledby="coinModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
    <div class="modal-header">
     <h5 class="modal-title" id="coinModalLabel">Coin Details</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
     <canvas id="coinChart" height="100"></canvas>
     <hr>
     <form action="process_purchase.php" method="POST">
      <input type="hidden" id="coinName" name="coin_name">
      <input type="hidden" id="coinSymbol" name="coin_symbol">
      <input type="hidden" id="coinPrice" name="coin_price">
      <div class="mb-3">
       <label for="amount" class="form-label">Amount</label>
       <input type="number" step="0.0001" class="form-control" id="amount" name="amount" placeholder="Number of coins" required>
      </div>
      <button type="submit" class="btn btn-primary w-100"><i class="fas fa-shopping-cart me-2"></i> Buy</button>
     </form>
    </div>
   </div>
  </div>
 </div>

 <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
  $(document).ready(function() {
   const apiUrl = "https://api.coincap.io/v2/assets";

   $.getJSON(apiUrl, function(data) {
    const cryptoList = data.data;
    let content = '';

    cryptoList.forEach(crypto => {
     content += `
      <div class="col-md-4">
       <div class="crypto-card">
        <h5><i class="fas fa-coins me-2"></i>${crypto.name} (${crypto.symbol})</h5>
        <p><strong>Price:</strong> $${parseFloat(crypto.priceUsd).toFixed(2)}</p>
        <button class="btn btn-primary mt-2" onclick="showCoinModal('${crypto.id}', '${crypto.name}', '${crypto.symbol}', ${crypto.priceUsd})"><i class="fas fa-info-circle me-2"></i>More</button>
       </div>
      </div>
     `;
    });

    $('#crypto-list').html(content);
   }).fail(function() {
    $('#crypto-list').html('<p class="text-danger">Error fetching data. Please try again later.</p>');
   });
  });

function showCoinModal(coinId, coinName, coinSymbol, coinPrice) {
 $('#coinModalLabel').text(`${coinName} (${coinSymbol})`);
 $('#coinName').val(coinName);
 $('#coinSymbol').val(coinSymbol);
 $('#coinPrice').val(coinPrice);

 const labels = [];
 const data = [];

 for (let i = 6; i >= 0; i--) {
  const date = new Date();
  date.setDate(date.getDate() - i);
  labels.push(date.toLocaleDateString('en-US', { weekday: 'short' }));
  data.push((coinPrice * (1 + (Math.random() - 0.5) / 10)).toFixed(2));
 }

 const ctx = document.getElementById('coinChart').getContext('2d');
 new Chart(ctx, {
  type: 'line',
  data: {
   labels: labels,
   datasets: [{
    label: `${coinName} Price`,
    data: data,
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
     display: true,
     title: {
      display: true,
      text: 'Days'
     }
    },
    y: {
     display: true,
     title: {
      display: true,
      text: 'Price in USD'
     }
    }
   }
  }
 });

 $('#coinModal').modal('show');
}
 </script>
</body>
</html>
