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
  <style>
    /* Styling here remains the same as previous example */
  </style>
</head>
<body>
<div class="container">
    <h1>Your Orders</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($userInfo['firstName']) . " " . htmlspecialchars($userInfo['lastName']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email']); ?></p>

    <ul id="orders-list">
        <?php 
        if (!empty($orderItems)) {
            foreach ($orderItems as $row) {
                echo "<li id='item-{$row['orderItemID']}' data-name='" . htmlspecialchars($row['productName']) . "' data-price='{$row['productPrice']}'>
                          <span>Order #{$row['orderItemID']} - " . htmlspecialchars($row['productName']) . " - ₱" . number_format($row['productPrice'], 2) . " - Order Time: " . htmlspecialchars($row['orderTime']) . " - User ID: " . $row['userID'] . "</span>
                      </li>";
            }
        } else {
            echo "<li>No recent orders found.</li>";
        }
        ?>
    </ul>

    <a class="back" href="profile.php">← Back</a>
</div>
</body>
</html>
