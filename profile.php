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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: rgb(241, 241, 217);
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
      border: 1px solid rgb(255, 117, 117);
    }
    h1 {
      color: #333;
      margin-bottom: 40px;
    }
    .back {
      margin-left: 0.2rem  ;
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
    .edit {
      margin-left: 10rem  ;
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
    .edit:hover {
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
      width: 90%;
      padding: 10px;
      margin: 5px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .update {
    margin-top: 1rem;
    margin-left:15.6rem;
    padding: 10px 20px;
    background-color: transparent;
    color: rgb(99, 207, 49);
    border: 1px solid rgb(99, 207, 49);
    border-radius: 5px;
    cursor: pointer;
    margin-right: 1rem;
    transition: 0.3s ease-in;
  }

  .cancel {
    margin-top: 1rem;
    padding: 10px 20px;
    background-color: transparent;
    color: rgb(62, 87, 170);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease-in;
    border: 1px solid rgb(62, 87, 170);
  }

  .edit-form .update:hover {
    background-color: rgb(99, 207, 49);
    color: white;
  }

  .edit-form .cancel:hover {
    background-color: darkblue;
    color: white;
  }
  /* Container for profile info */
.profile-info {
  display: flex;
  align-items: center; /* Align items horizontally */
  margin-bottom: 15px; /* Add some space between sections */
}

.profile-info i {
  font-size: 24px; /* Make icons larger */
  margin-right: 10px; /* Space between the icon and the text */
  color:rgb(255, 99, 99); /* Set color for the icons */
}

.profile-info p {
  font-size: 16px; /* Set font size for the text */
  margin: 0; /* Remove extra margin */
}

.profile-info strong {
  font-weight: bold;
}

.click {
    margin-top: 1rem;
    padding: 10px 20px;
    background-color: transparent;
    color: rgb(99, 207, 49);
    border: 1px solid rgb(99, 207, 49);
    border-radius: 5px;
    cursor: pointer;
    margin-right: 1rem;
    transition: 0.3s ease-in;
    
  }
 .click:hover {
    background-color:rgb(99, 207, 49) ;
    color: white;
  }
  .click i {
  margin-right: 8px;
}
.split-container {
  display: flex;
  justify-content: space-between;
  align-items: stretch;
  gap: 40px;
  margin-top: 40px;
  
}

.profile-container, .edit-form-wrapper {
  width: 45%;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  border: 1px solid rgb(255, 117, 117);
}


.purchase:hover {
    color:  #ff6666;
  }
</style>
</head>
<body>

<div class="split-container">
  <div class="profile-container">
    <div class="profile-info">
    <h1>Profile</h1>
    </div>
  

    <!-- Display First Name and Last Name -->
    <div class="profile-info">
      <i class="fas fa-user icon"></i>
      <p><strong>First Name:</strong> <?php echo htmlspecialchars($_SESSION['firstName']) . ' ' . htmlspecialchars($_SESSION['lastName']); ?></p>
    </div>

    <!-- Display Date of Birth -->
    <div class="profile-info">
      <i class="fas fa-calendar icon"></i>
      <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($_SESSION['DOB']); ?></p>
    </div>

    <!-- Display Address -->
    <div class="profile-info">
      <i class="fas fa-map-marker-alt icon"></i>
      <p><strong>Address:</strong> <?php echo htmlspecialchars($_SESSION['address']); ?></p>
    </div>

    <!-- Display Email -->
    <div class="profile-info">
      <i class="fas fa-envelope icon"></i>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    </div>

    <p>________________________________________________________________</p>

    <h2>My Purchases</h2>
    <div class="purchases">
      <button type="button" class="click" onclick="window.location.href='order.php'">
        <i class="fas fa-shopping-cart icon"></i> Click
      </button>
    </div>
    <a href="product2.html?edit=true" class="purchase">Purchase More</a>
    <a href="profile.php?edit=true" class="edit">Edit Profile</a>
    <a class="back" href="index2.html">← Back to Home</a>
    <a class="orders" href="listOrders.php">←Orders</a>
  </div>
 
  <?php if (isset($_GET['edit']) && $_GET['edit'] == 'true'): ?>
    <!-- Vertical Line -->
    <div class="vertical-line"></div>

    <!-- Edit Form -->
    <div class="edit-form-wrapper">
      <h2>Edit Profile</h2>
      <form class="edit-form" method="post">
        <input type="text" name="firstName" value="<?php echo htmlspecialchars($_SESSION['firstName']); ?>" required>
        <input type="text" name="lastName" value="<?php echo htmlspecialchars($_SESSION['lastName']); ?>" required>
        <input type="date" name="DOB" value="<?php echo htmlspecialchars($_SESSION['DOB']); ?>" required>
        <input type="text" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>" required>
        <button type="submit" class="update" name="update">Update Profile</button>
        <button type="button" class="cancel" onclick="window.location.href='profile.php'">Cancel</button>
      </form>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
