<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login"; // Replace with your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$query = "SELECT orderItemID, orderID, productName, productPrice FROM order_items WHERE email = '$email' ORDER BY orderItemID DESC"; 
$result = $conn->query($query);

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax']) && $_POST['ajax'] == "delete") {
  $orderItemID = $_POST['orderItemID'];

  $deleteQuery = "DELETE FROM order_items WHERE orderItemID = ?";
  $stmt = $conn->prepare($deleteQuery);
  $stmt->bind_param("i", $orderItemID);

  if ($stmt->execute()) {
      echo json_encode(["success" => true]);
  } else {
      echo json_encode(["success" => false, "error" => $stmt->error]);
  }

  $stmt->close();
  $conn->close();
  exit(); // Only respond to AJAX, stop further rendering

}

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

li form {
  display: inline-block;
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
    <p>Below is a list of your recent orders:</p>
    <ul id="orders-list">
  <?php 
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<li id='item-{$row['orderItemID']}'>
              <span>Item #{$row['orderID']} - {$row['productName']} - ₱{$row['productPrice']}</span>
              <button class='delete-button' data-id='{$row['orderItemID']}'>Delete</button>
            </li>";
    }
  } else {
    echo "<li>No recent orders found.</li>";
  }
  ?>
</ul>

    <a class="back" href="index2.html">← Back to Home</a>
  </div>
</body>
<script>
document.querySelectorAll('.delete-button').forEach(button => {
  button.addEventListener('click', function () {
    const orderItemID = this.dataset.id;
    if (!confirm("Are you sure you want to delete this order item?")) return;

    fetch('', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `ajax=delete&orderItemID=${orderItemID}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Order item deleted successfully!");
        document.getElementById(`item-${orderItemID}`).remove();
      } else {
        alert("Error deleting item: " + data.error);
      }
    });
  });
});
</script>
</html>

<?php
$conn->close();
?>
