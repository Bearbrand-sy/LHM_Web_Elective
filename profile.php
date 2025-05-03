<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['firstName']) || !isset($_SESSION['lastName']) || !isset($_SESSION['DOB']) || !isset($_SESSION['address'])) {
    include 'connect.php'; 

    $email = $_SESSION['email'];  
    $query = "SELECT firstName, lastName, DOB, address FROM users WHERE email = '$email'"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['DOB'] = $row['DOB'];
        $_SESSION['address'] = $row['address'];  
    } else {
        echo "Error: User data not found.";
        exit();
    }
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
      margin: 0;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    h1 {
      color: #333;
      margin-bottom: 20px;
    }
    .back {
      display: inline-block;
      padding: 10px 20px;
      color: red;
      text-decoration: none;
      border: 1px solid red;
      border-radius: 5px;
      font-size: 14px;
      margin-top: 30px;
      transition: background 0.3s ease-in, color 0.3s ease-in;
    }
    .back:hover {
      background: red;
      color: white;
    }
    p {
      font-size: 16px;
      color: #555;
    }
    .profile-info {
      margin-bottom: 15px;
      text-align: left;
    }
  </style>
</head>
<body>


  <div class="container">
    <h1>Welcome to your Profile</h1>
    
    <!-- Display First Name and Last Name -->
    <div class="profile-info">
      <p><strong>First Name:</strong> <?php echo htmlspecialchars($_SESSION['firstName']); ?></p>
      <p><strong>Last Name:</strong> <?php echo htmlspecialchars($_SESSION['lastName']); ?></p>
    </div>
    
    <!-- Display Date of Birth -->
    <div class="profile-info">
      <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($_SESSION['DOB']); ?></p>
    </div>
    
    <!-- Display Email -->
    <div class="profile-info">
      <p><strong>Address:</strong> <?php echo htmlspecialchars($_SESSION['address']); ?></p>
    </div>
    
    <!-- Display Email -->
    <div class="profile-info">
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    </div>
    
    <!-- Back Button -->
    <a class="back" href="index2.html">← Back to Home</a>
  </div>
</body>
</html>


