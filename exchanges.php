<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>CryptoMania - Exchanges Overview</title>
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
  .exchange-card {
   border: none;
    border-radius: 10px;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
   margin: 20px 0;
   transition: transform 0.3s;
   background-color: #f8f9fa;
  }
  .exchange-card:hover {
   transform: translateY(-10px);
  }
  .section-title {
   font-weight: bold;
    margin-top: 40px;
    text-align: center;
  }
 </style>
</head>
<body>
 <?php include 'includes/navbar.php'; ?>

 <!-- Hero Section -->
 <div class="hero-section">
   <h1>Explore Global Exchanges</h1>
   <p>Discover the top cryptocurrency exchanges from around the world and compare their rankings and volumes.</p>
 </div>

 <!-- Exchanges Section -->
 <div class="container mt-5">
  <h2 class="section-title">Top Exchanges</h2>
  <div id="exchange-list" class="row"></div>
 </div>

 <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
 <script>
  $(document).ready(function() {
   const apiUrl = "https://api.coincap.io/v2/exchanges";

   $.getJSON(apiUrl, function(data) {
    const exchanges = data.data;
    let content = '';

    exchanges.forEach(exchange => {
     content += `
      <div class="col-md-4">
       <div class="exchange-card">
        <h5><i class="fas fa-chart-line me-2"></i>${exchange.name}</h5>
        <p><strong>Rank:</strong> ${exchange.rank}</p>
        <p><strong>Volume (USD):</strong> $${parseFloat(exchange.volumeUsd).toLocaleString()}</p>
        <a href="${exchange.exchangeUrl}" target="_blank" class="btn btn-primary mt-2"><i class="fas fa-external-link-alt me-2"></i>Visit Website</a>
       </div>
      </div>
     `;
    });

    $('#exchange-list').html(content);
   }).fail(function() {
    $('#exchange-list').html('<p class="text-danger">Error fetching data. Please try again later.</p>');
   });
  });
 </script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
