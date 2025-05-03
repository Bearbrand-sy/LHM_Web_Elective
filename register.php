<?php
include 'connect.php';
session_start();

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists!'); window.location.href='register.php';</script>";
    } else {
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password) 
                        VALUES ('$firstName', '$lastName', '$email', '$password')";

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