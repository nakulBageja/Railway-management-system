<?php
// Initialize the session
session_start(); // href="php.net/manual/en/function.session-start.php

// Check if the user is logged in, if not then redirect him to login page
$name;
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: index.php");
  exit;
} 
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="main.css">

</head>

<body>
  <div class="wrap">
    <ul class="navbar">
      <img class="logo" src="resources/logo_1.jpg">
      <li><a href="index">Home</a></li>
      <li><a href="logout">logout</a></li>
      <li><a href="trains">Search Train</a></li>
      <li><a href="contact">Contact</a></li>
      <img class="logo2" src="resources/irctc.png">
    </ul>
  </div>
  <div class="textheading">
    <label>Indian Railways</label>
    <span>Safety</span>
    <span>Security</span>
    <span>Punctuality</span>
  </div>

</body>

</html>