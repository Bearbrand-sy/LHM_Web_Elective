<?php
session_start();
include("connect.php");

// Logout logic
if (isset($_GET['logout'])) {
    session_unset();  // Remove all session variables
    session_destroy();  // Destroy the session
    header("Location: login.php");  // Redirect to login page after logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            padding-top: 15%;
        }

        .greeting {
            font-size: 50px;
            font-weight: bold;
            color: #333;
        }

        .logout-btn {
            background-color: #ff4c4c; /* Red color */
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #ff1f1f; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="greeting">
            Hello 
            <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                if ($row = mysqli_fetch_assoc($query)) {
                    echo $row['firstName'] . ' ' . $row['lastName'];
                }
            } else {
                echo "Guest";
            }
            ?>
        </p>

        <?php if (isset($_SESSION['email'])) { ?>
            <!-- Show the logout button if user is logged in -->
            <a href="?logout=true">
                <button class="logout-btn">Logout</button>
            </a>
        <?php } ?>
    </div>
</body>
</html>