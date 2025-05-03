<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Orders</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      padding: 40px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #444;
    }
    ul {
      list-style-type: none;
      padding-left: 0;
    }
    li {
      padding: 10px 0;
      border-bottom: 1px solid #eee;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Your Orders</h1>
    <p>Below is a placeholder list of your recent orders:</p>
    <ul>
      <li>Order #12345 - Delivered</li>
      <li>Order #12346 - Processing</li>
      <li>Order #12347 - Shipped</li>
    </ul>
    <a href="index2.html">← Back to Home</a>
  </div>
</body>
</html>
