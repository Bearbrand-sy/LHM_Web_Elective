<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
      
        body {
          background: linear-gradient(120deg,rgb(241, 241, 217),rgb(255, 249, 198));
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          flex-direction: column;
          padding: 20px;
        }
      
        .container {
          background-color: white;
          padding: 2rem;
          border-radius: 16px;
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
          width: 100%;
          max-width: 400px;
          margin-bottom: 30px;
          border: 1px solid rgb(236, 93, 93);
        }
      
        .form-title {
          text-align: center;
          font-size: 2rem;
          margin-bottom: 1.5rem;
          color: #333;
        }
      
        .input-group {
          position: relative;
          margin-bottom: 1.5rem;
        }
      
        .input-group i {
          position: absolute;
          top: 50%;
          left: 10px;
          transform: translateY(-50%);
          color: #999;
        }
      
        .input-group input {
          width: 100%;
          padding: 10px 10px 10px 30px;
          border: 1px solid #ccc;
          border-radius: 8px;
          outline: none;
          transition: 0.3s;
        }
      
        .input-group input:focus {
          border-color: #5d9cec;
        }
      
        .input-group label {
          font-size: 0.9rem;
          color: #777;
          margin-top: 5px;
          display: block;
        }
      
        .btn {
          width: 100%;
          padding: 12px;
          background-color:rgb(236, 93, 93);
          border: none;
          border-radius: 8px;
          color: white;
          font-weight: bold;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }
      
        .btn:hover {
          background-color:rgb(163, 58, 58);
        }
      
        .or {
          text-align: center;
          margin: 1.5rem 0;
          color: #888;
        }
      
        .icons {
          display: flex;
          justify-content: center;
          gap: 20px;
          font-size: 1.5rem;
          margin-bottom: 1.5rem;
        }
      
        .icons i {
          cursor: pointer;
          color: #333;
          transition: color 0.3s;
        }
      
        .icons i:hover {
          color: #333;
        }
      
        .links {
          text-align: center;
        }
      
        .links p {
          margin-bottom: 0.5rem;
          color: #555;
        }
      
        .links button {
          background: none;
          border: none;
          color:rgb(255, 111, 111);
          font-weight: bold;
          cursor: pointer;
          font-size: 1rem;
          transition: color 0.3s;
        }
      
        .links button:hover {
          color:rgb(255, 105, 105);
        }
      
        @media (max-width: 480px) {
          .container {
            padding: 1.5rem;
          }
      
          .form-title {
            font-size: 1.5rem;
          }
        }
        i{
            margin-top: 10px;
        }

        #showPassword {
    margin-left: 0; 
          }

          label {
              margin-left: 10px; 
              font-size: 14px;
          }
          .input-group1 {
              display: flex;
              align-items: center; 
              margin-top: 10px;
              margin-bottom: 2rem;
              margin-left:13rem;
          }
          .input-group1 label {
              margin-left: 10px; 
              font-size: 14px;
              color: gray; 
          }
          .input-group2 {
            position: relative;
            
          }

        .input-group2 i {
          position: absolute;
          top: 50%;
          left: 10px;
          transform: translateY(-50%);
          color: #999;
        }
      
        .input-group2 input {
          width: 100%;
          padding: 10px 10px 10px 30px;
          border: 1px solid #ccc;
          border-radius: 8px;
          outline: none;
          transition: 0.3s;
        }
      
        .input-group2 input:focus {
          border-color: #5d9cec;
        }
      
        .input-group2 label {
          font-size: 0.9rem;
          color: #777;
          margin-top: 5px;
          display: block;
        }
      </style>
      
</head>
<body>
    <div class="container" id="signUp" style="display: none;">
        <h1 class="form-title">Register</h1>

        <form method="post" action="register.php">
    <div class="input-group">
        <label for="fname">First Name</label>
        <i class="fas fa-user"></i>
        <input type="text" name="fname" id="fname" placeholder="First name" required>
    </div>

    <div class="input-group">
        <label for="lname">Last Name</label>
        <i class="fas fa-user"></i>
        <input type="text" name="lname" id="lname" placeholder="Last name" required>
    </div>

    <div class="input-group">
        <label for="email">Email Address</label>
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" placeholder="Email" required>
    </div>

    <div class="input-group2">
        <label for="password">Password</label>
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" placeholder="Password" required>
    </div>

    <div class="input-group1">
    <input type="checkbox" id="showPassword" onclick="togglePassword()">
    <label for="showPassword" style="display: inline-block; margin-left: 5px;">Show Password</label>
</div>

    <input type="submit" class="btn" value="Sign up" name="signUp">
</form>
    <p class="or">
        ---------or---------
    </p>
    <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
    </div>
    <div class="links">
        <p>Already Have Account?</p>
        <button id="signInButton"> Sign In</button>
    </div>
    </div>


    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>

        <form method="post" action="register.php">

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" placeholder="Email " required>
            
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
            
        </div>
        <input type="submit" class="btn" value="Sign In" name="signIn">
    </form>
    <p class="or">
        ---------or---------
    </p>
    <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
    </div>
    <div class="links">
        <p>Dont have account yet??</p>
        <button id="signUpButton"> Sign Up</button>
    </div>
    </div>

</body>
<script src="script.js"></script>
</html>