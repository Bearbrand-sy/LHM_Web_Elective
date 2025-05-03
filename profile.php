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
  <title>Your Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
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
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to your Profile</h1>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <p>You can customize this page to show profile details, update options, etc.</p>
    <a href="index2.html">← Back to Home</a>
  </div>
</body>
</html>
