<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $Email = $pnumber = "";
$username_err = $password_err = $confirm_password_err = $Email_err = $pnumber_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) { //prepare an SQL statement for execution
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

//     if (empty(trim($_POST["Email"]))) {
//         $Email_err = "Please enter a Email.";
//     } else {
//         // Prepare a select statement
//         $sql = "SELECT id FROM users WHERE Email = ?";

//         if ($stmt = mysqli_prepare($link, $sql)) { //prepare an SQL statement for execution
//             // Bind variables to the prepared statement as parameters
//             mysqli_stmt_bind_param($stmt, "s", $param_Email);

//             // Set parameters
//             $param_Email = trim($_POST["Email"]);

//             // Attempt to execute the prepared statement
//             if (mysqli_stmt_execute($stmt)) {
//                 /* store result */
//                 mysqli_stmt_store_result($stmt);

//                 if (mysqli_stmt_num_rows($stmt) == 1) {
//                     $Email_err = "This Email is already taken.";
//                 } else {
//                     $Email = trim($_POST["Email"]);
//                 }
//             } else {
//                 echo "Oops! Something went wrong. Please try again later.";
//             }
//         }

//         // Close statement
//         mysqli_stmt_close($stmt);
//     //}
//     // if (empty(trim($_POST["pnumber"]))) {
//     //     $pnumber_err = "Please enter a pnumber.";
//     // } else {
//         // Prepare a select statement
//         $sql = "SELECT id FROM users WHERE pnumber = ?";

//         if ($stmt = mysqli_prepare($link, $sql)) { //prepare an SQL statement for execution
//             // Bind variables to the prepared statement as parameters
//             mysqli_stmt_bind_param($stmt, "s", $param_pnumber);

//             // Set parameters
//             $param_pnumber = trim($_POST["Email"]);

//             // Attempt to execute the prepared statement
//             if (mysqli_stmt_execute($stmt)) {
//                 /* store result */
//                 mysqli_stmt_store_result($stmt);

//                 if (mysqli_stmt_num_rows($stmt) == 1) {
//                     $pnumber_err = "This Email is already taken.";
//                 } else {
//                     $pnumber = trim($_POST["Email"]);
//                 }
//             } else {
//                 echo "Oops! Something went wrong. Please try again later.";
//             }
//         }

//         // Close statement
//         mysqli_stmt_close($stmt);
//    // }


    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: index.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            background-image: url(resources/train.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
            margin: 10;
            background-color: #81D4FA;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <div class= "wrap">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <!-- <div class="form-group <?php echo (!empty($pnumber)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="number" class="form-control" value="<?php echo $pnumber; ?>">
                <span class="help-block"><?php echo $pnumber; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($Email)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $Email; ?>">
                <span class="help-block"><?php echo $Email; ?></span>
            </div> -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
        </form>
    </div>
</body>

</html>