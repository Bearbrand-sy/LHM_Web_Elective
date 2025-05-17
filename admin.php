<?php
session_start();

// Only allow admin@example.com (change as needed)
if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@gmail.com') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$users = $conn->query("SELECT userID, firstName, lastName, email FROM users");

// Fetch all order_items joined to users to get userID 
$orders = $conn->query(
    "SELECT 
        oi.orderItemID,
        oi.productName,
        oi.productPrice,
        oi.orderTime,
        u.userID,
        oi.email
     FROM order_items oi 
     JOIN users u ON oi.email = u.email
     ORDER BY oi.orderItemID DESC"
);

// Automatically insert order_items into orders table if not already inserted
$ordersData = $conn->query(
  "SELECT 
      oi.productName,
      oi.productPrice,
      oi.orderTime,
      u.userID,
      oi.email,
      oi.orderItemID
   FROM order_items oi
   JOIN users u ON oi.email = u.email
   LEFT JOIN orders o ON oi.orderItemID = o.orderItemID
   WHERE o.orderItemID IS NULL"
);

if ($ordersData->num_rows > 0) {
  $stmt = $conn->prepare(
      "INSERT INTO orders (productName, productPrice, orderTime, userID, email, orderItemID)
      VALUES (?, ?, ?, ?, ?, ?)"
  );

  while ($order = $ordersData->fetch_assoc()) {
      $stmt->bind_param(
          "sssdss",
          $order['productName'],
          $order['productPrice'],
          $order['orderTime'],
          $order['userID'],
          $order['email'],
          $order['orderItemID']
      );
      $stmt->execute();
  }

  $stmt->close();
}


// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}

?>

<?php if (isset($successMessage)): ?>
<script>
    alert("<?= addslashes($successMessage) ?>");
</script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: rgb(241,241,217);
      margin: 0;
      padding: 40px;
    }
    .container {
      max-width: 1000px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      border: 1px solid rgb(255,117,117);
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 { text-align: center; color: #333; margin-bottom: 30px; }
    table {
      width: 100%; border-collapse: collapse; margin-bottom: 40px;
    }
    th, td {
      border: 1px solid #ccc; padding: 12px; text-align: left;
    }
    th {
      background-color: rgb(255,117,117); color: white;
    }
    tr:nth-child(even) { background-color: #f9f9f9; }
    .button {
      display: inline-block;
      padding: 10px 20px;
      margin-right: 10px;
      color: red;
      border: 1px solid red;
      border-radius: 5px;
      text-decoration: none;
      background: white;
      cursor: pointer;
    }
    .button:hover {
      background: red;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Admin Dashboard</h1>

    <h2>Registered Users</h2>
    <table>
      <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
      </tr>
      <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
          <td><?= $user['userID'] ?></td>
          <td><?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>

    <h2>Order Items</h2>
    <table>
      <tr>
        <th>Order Item ID</th>
        <th>Product</th>
        <th>Price</th>
        <th>Order Time</th>
        <th>User ID</th>
        <th>Email</th>
      </tr>
      <?php while ($order = $orders->fetch_assoc()): ?>
        <tr>
          <td><?= $order['orderItemID'] ?></td>
          <td><?= htmlspecialchars($order['productName']) ?></td>
          <td>₱<?= number_format($order['productPrice'], 2) ?></td>
          <td><?= htmlspecialchars($order['orderTime']) ?></td>
          <td><?= htmlspecialchars($order['userID']) ?></td>
          <td><?= htmlspecialchars($order['email']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>

    <?php if (isset($successMessage)): ?>
<script>
    alert("<?= addslashes($successMessage) ?>");
</script>
<?php endif; ?>

    <!-- Logout Button -->
    <form method="post" style="display:inline;">
      <button type="submit" name="logout" class="button">Logout</button>
    </form>
  </div>
</body>
</html>
