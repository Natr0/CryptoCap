<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CryptoCap - Crypto News</title>
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
    .news-card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin: 20px 0;
      transition: transform 0.3s;
      background-color: #f8f9fa;
    }
    .news-card:hover {
      transform: translateY(-10px);
    }
    .news-card img {
      width: 100%;
      height: auto;
      border-radius: 5px;
      margin-bottom: 15px;
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
    <h1>Latest Crypto News</h1>
    <p>Stay informed with the latest updates and trends in the world of cryptocurrency.</p>
  </div>

  <!-- News Section -->
  <div class="container mt-5">
    <h2 class="section-title">Recent Articles</h2>
    <div id="news-list" class="row"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      const apiUrl = "https://api.rss2json.com/v1/api.json?rss_url=https://www.coindesk.com/arc/outboundfeeds/rss/";

      // Fetch news articles and display them
      $.getJSON(apiUrl, function(data) {
        const newsItems = data.items;
        let content = '';

        newsItems.forEach(news => {
          content += `
            <div class="col-md-4">
              <div class="news-card">
                <img src="${news.enclosure.link}" alt="${news.title}">
                <h5>${news.title}</h5>
                <p><small class="text-muted">${new Date(news.pubDate).toDateString()}</small></p>
                <p>${news.description.substring(0, 100)}...</p>
                <a href="${news.link}" target="_blank" class="btn btn-primary">Read More</a>
              </div>
            </div>
          `;
        });

        $('#news-list').html(content);
      }).fail(function() {
        $('#news-list').html('<p class="text-danger">Error fetching news articles. Please try again later.</p>');
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
