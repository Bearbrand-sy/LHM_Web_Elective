<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

// Get the user's information (without address, payment method, and postal code)
$query = "SELECT firstName, lastName, email FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$userInfo = $stmt->get_result()->fetch_assoc();

// Get the user's order items
$query = "SELECT oi.orderItemID, oi.productName, oi.productPrice, oi.orderTime, u.userID 
          FROM order_items oi 
          JOIN users u ON oi.email = u.email
          WHERE oi.email = ? 
          ORDER BY oi.orderItemID DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$orderItems = [];
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Orders</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: rgb(241, 241, 217);
      margin: 0;
      padding: 40px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      border: 1px solid rgb(255, 117, 117);
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }

    .icon {
  margin-right: 8px;
  color: #ff7575;
  vertical-align: middle;
}

    .order-card {
      border: 1px solid #ccc;
      border-left: 5px solid rgb(255, 117, 117);
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 8px;
      background-color: #fafafa;
    }

    .order-item {
      display: flex;
      justify-content: space-between;
      padding: 6px 0;
      border-bottom: 1px dashed #ddd;
      font-size: 15px;
    }

    .order-item:last-child {
      border-bottom: none;
    }

    .order-summary {
      text-align: right;
      margin-top: 10px;
      font-weight: bold;
      color: #555;
    }

    .back-button, .back {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      color: red;
      border: 1px solid red;
      border-radius: 5px;
      text-decoration: none;
      transition: 0.3s;
    }

    .back-button:hover, .back:hover {
      background: red;
      color: white;
    }
    .orders-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 6px;
  overflow: hidden;
}

.orders-table th,
.orders-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.orders-table th {
  background-color: #ffe5e5;
  color: #333;
}

.orders-table tr:nth-child(even) {
  background-color: #f9f9f9;
}
  </style>
</head>
<body>
<div class="container">
    <h1>Your Orders</h1>
    <p><i class="fas fa-user icon"></i> <strong>Name:</strong> <?php echo htmlspecialchars($userInfo['firstName']) . " " . htmlspecialchars($userInfo['lastName']); ?></p>
<p><i class="fas fa-envelope icon"></i> <strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email']); ?></p>


<table class="orders-table">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Order Time</th>
            <th>User ID</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($orderItems)) {
            foreach ($orderItems as $row) {
                echo "<tr>
                        <td>{$row['orderItemID']}</td>
                        <td>" . htmlspecialchars($row['productName']) . "</td>
                        <td>₱" . number_format($row['productPrice'], 2) . "</td>
                        <td>" . htmlspecialchars($row['orderTime']) . "</td>
                        <td>{$row['userID']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No recent orders found.</td></tr>";
        }
        ?>
    </tbody>
</table>


    <a class="back" href="profile.php">← Back</a>
</div>
</body>
</html>
