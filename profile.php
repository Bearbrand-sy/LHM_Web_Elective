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

// Handle the form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    include 'connect.php';
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $DOB = $_POST['DOB'];
    $address = $_POST['address'];
    $email = $_SESSION['email'];

    // Update query to update user information in the database
    $updateQuery = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', DOB = '$DOB', address = '$address' WHERE email = '$email'";
    
    if ($conn->query($updateQuery) === TRUE) {
        // Update session variables after successful update
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['DOB'] = $DOB;
        $_SESSION['address'] = $address;

        echo "<script>alert('Profile updated successfully'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
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
    .edit-form input {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .edit-form button {
      padding: 10px 20px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .edit-form button:hover {
      background-color: darkgreen;
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
    
    <!-- Display Address -->
    <div class="profile-info">
      <p><strong>Address:</strong> <?php echo htmlspecialchars($_SESSION['address']); ?></p>
    </div>
    
    <!-- Display Email -->
    <div class="profile-info">
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    </div>

    <!-- Edit Button to open the edit form -->
    <a href="profile.php?edit=true" class="back">Edit Profile</a>
    
    <!-- Edit Form (when the 'edit' query parameter is set) -->
    <?php if (isset($_GET['edit']) && $_GET['edit'] == 'true'): ?>
      <h2>Edit Profile</h2>
      <form class="edit-form" method="post">
        <input type="text" name="firstName" value="<?php echo htmlspecialchars($_SESSION['firstName']); ?>" required>
        <input type="text" name="lastName" value="<?php echo htmlspecialchars($_SESSION['lastName']); ?>" required>
        <input type="date" name="DOB" value="<?php echo htmlspecialchars($_SESSION['DOB']); ?>" required>
        <input type="text" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>" required>
        <button type="submit" name="update">Update Profile</button>
      </form>
    <?php endif; ?>

    <!-- Back Button -->
    <a class="back" href="index2.html">← Back to Home</a>
  </div>
</body>
</html>
