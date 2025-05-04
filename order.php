<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productName'], $_POST['productPrice'])) {
    $productName = $_POST['productName'];
    $productPrice = floatval($_POST['productPrice']);

    $query = "INSERT INTO order_items (email, productName, productPrice) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssd", $email, $productName, $productPrice);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $stmt->close();
    exit();
}

$query = "SELECT orderItemID, orderID, productName, productPrice FROM order_items WHERE email = ? ORDER BY orderItemID DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$orderItems = [];
$totalAmount = 0;

while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;
    $totalAmount += $row['productPrice'];
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
    /* General body styling */
body {
  font-family: 'Arial', sans-serif;
  background-color: #f4f4f4;
  padding: 40px;
  margin: 0;
  color: #333;
}

/* Container for the page content */
.container {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  border: 1px solid rgb(255, 110, 110);
}

/* Heading styles */
h1 {
  font-size: 28px;
  color: #333;
  margin-bottom: 20px;
}

/* Styling the orders list */
ul {
  list-style-type: none;
  padding-left: 0;
}

li {
  background-color: #f9f9f9;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

li span {
  font-size: 16px;
  font-weight: 600;
}

li .delete-button {
  background-color: #e74c3c;
  color: white;
  padding: 8px 15px;
  font-size: 14px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

li .delete-button:hover {
  background-color: #c0392b;
}

/* Back button styling */
.back {
  display: inline-block;
  padding: 10px 20px;
  color: white;
  background-color: transparent;
  text-decoration: none;
  border-radius: 5px;
  font-size: 14px;
  margin-top: 20px;
  text-align: center;
  transition: background-color 0.3s;
  border: 1px solid  #c0392b; 
  color: #c0392b;
}

.back:hover {
  background-color:rgb(255, 86, 86);
  color: white;
}

/* Responsive Design for small screens */
@media (max-width: 768px) {
  .container {
    padding: 15px;
  }

  h1 {
    font-size: 24px;
  }

  li {
    padding: 10px;
    font-size: 14px;
  }

  .back {
    width: 100%;
    text-align: center;
  }
}

  </style>
</head>
<body>
<div class="container">
    <h1>Your Orders</h1>
    <ul id="orders-list">
  <?php 
  if (!empty($orderItems)) {
    foreach ($orderItems as $row) {
      echo "<li id='item-{$row['orderItemID']}' data-name='" . htmlspecialchars($row['productName']) . "' data-price='{$row['productPrice']}'>
              <span>Item #{$row['orderItemID']} - " . htmlspecialchars($row['productName']) . " - ₱" . number_format($row['productPrice'], 2) . "</span>
              <button class='delete-button' data-id='{$row['orderItemID']}'>Cancel</button>
            </li>";
    }
  } else {
    echo "<li>No recent orders found.</li>";
  }
  ?>
</ul>

<p style="text-align:right; margin-right: 2rem;">
  <strong>Total Amount: ₱<span id="total-amount"><?php echo number_format($totalAmount, 2); ?></span></strong>
</p>

<a class="back" href="profile.php">← Back</a>
</div>
</body>

<script>
const products = [
  { "name": "3-colored Beads Bracelet", "type": "bracelet", "image": "./assets/brace1.png", "price": "₱50" },
  { "name": "3-colored Necklace", "type": "necklace", "image": "./assets/neck1.png", "price": "₱100" },
  { "name": "Red Black Earrings", "type": "earring", "image": "./assets/ear1.png",  "price": "₱90" },
  { "name": "Black Bracelet", "type": "bracelet", "image": "./assets/brace2.png", "price": "₱60" },
  { "name": "Cat Face bracelet", "type": "bracelet", "image": "./assets/brace5.png", "price": "₱120" },
  { "name": "Tribal Earrings", "type": "earring", "image": "./assets/ear2.png",  "price": "₱40" },
  { "name": "White Pearl Bracelet", "type": "bracelet", "image": "./assets/brace6.png", "price": "₱85" },
  { "name": "Philippines Style Earring ", "type": "earring", "image": "./assets/ear3.png",  "price": "₱80" },
  { "name": "Flower Bead Bracelet ", "type": "bracelet", "image": "./assets/brace3.png",  "price": "₱100" },
  { "name": "Spiral Bead Necklace", "type": "necklace", "image": "./assets/neck2.png", "price": "₱120" },
  { "name": "Sunflower Necklace", "type": "necklace", "image": "./assets/neck3.png",  "price": "₱140" },
  { "name": "Heart Black Bracelet", "type": "bracelet", "image": "./assets/brace4.png", "price": "₱90" }
];

// Add product image to each list item
document.querySelectorAll('#orders-list li').forEach(li => {
  const name = li.dataset.name?.trim();
  const product = products.find(p => p.name.trim() === name);
  if (product) {
    const img = document.createElement('img');
    img.src = product.image;
    img.alt = product.name;
    img.style.width = '60px';
    img.style.height = '60px';
    img.style.borderRadius = '5px';
    li.insertBefore(img, li.querySelector('span'));
  }
});

// Delete button logic
document.querySelectorAll('.delete-button').forEach(button => {
  button.addEventListener('click', function () {
    const orderItemID = this.dataset.id;
    if (!confirm("Are you sure you want to cancel this order item?")) return;

    fetch('delete.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `orderItemID=${orderItemID}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const itemElement = document.getElementById(`item-${orderItemID}`);
        const price = parseFloat(itemElement.dataset.price);
        itemElement.remove();
        alert("Order item cancelled successfully!");

        // Update total
        const totalElement = document.getElementById('total-amount');
        const currentTotal = parseFloat(totalElement.textContent.replace('₱', ''));
        const newTotal = currentTotal - price;
        totalElement.textContent = newTotal.toFixed(2);

        // If no items left, show empty message
        if (document.querySelectorAll('#orders-list li').length === 0) {
          document.getElementById('orders-list').innerHTML = "<li>No recent orders found.</li>";
          totalElement.textContent = "0.00";
        }

      } else {
        alert("Error deleting item: " + data.error);
      }
    })
    .catch(error => {
      alert("Request failed: " + error);
    });
  });
});
</script>
</html>
