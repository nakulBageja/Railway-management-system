<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: welcome.php");
  exit;
}

require_once "config.php";


$username = $password = "";
$username_err = $password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }


  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }


  if (empty($username_err) && empty($password_err)) {
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      
      mysqli_stmt_bind_param($stmt, "s", $param_username);

    
      $param_username = $username;

     
      if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
 
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
             
              session_start();

            
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;

          
              header("location:trains.php");
            } else {
              
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
         
          $username_err = "No account found with that username.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

  
    mysqli_stmt_close($stmt);
  }

  
  mysqli_close($link);
}

?>
<script>
  function error() {
    alert("Please login First");
  }
</script>
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
      <li><a onclick="error()">Search Train</a></li>
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
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container">
    <h1>Login</h1>

    <label for="email"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" value="<?php echo $username; ?>" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button type="submit" class="btn">Login</button>
    <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    <p>Forgot password? <a href="reset_pass.php">Reset Your Password</a>.</p>
  </form>
  </div>


</body>

</html>