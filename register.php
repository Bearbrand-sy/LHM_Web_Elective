<?php
include 'connect.php';
session_start();

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $DOB = $_POST['DOB'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $address = $_POST['address'];

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists!'); window.location.href='register.php';</script>";
    } else {
        // Insert new user into the database without password hashing
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password, DOB, address) 
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$DOB', '$address')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "'); window.location.href='register.php';</script>";
        }
    }
}


if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Check if admin
    if ($email === 'admin@gmail.com' && $password === 'admin') {
        $_SESSION['email'] = $email;
        echo "<script>alert('Admin login successful!'); window.location.href='admin.php';</script>";
        exit();
    }

    // Regular user login
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        echo "<script>alert('Login successful!'); window.location.href='index2.html';</script>";
        exit();
    } else {
        echo "<script>alert('Incorrect email or password.'); window.location.href='login.php';</script>";
    }
}
?>