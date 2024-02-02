<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
</head>
<body>
    <!-- Navbar Section-->
    <nav class="navbar">
        <div class="navbar__container">
            <a href="/">
                <img src="/images/logo.png" alt="Logo" id="navbar__logo">
            </a>
            <div class="navbar__toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="/" class="navbar__links">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="/" class="navbar__links">About us</a>
                </li>
                <li class="navbar__item">
                    <a href="/" class="navbar__links">Contacts</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Registration Form -->
    <div class="registration__wrapper">
    <?php
            if (isset($_POST["submit"])) {
                $fullName = $_POST["fullName"];
                $phoneNumber = $_POST["phoneNumber"];
                $email = $_POST["email"];
                $address = $_POST["address"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirmPassword"];
                $role = $_POST["role"];
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $errors = [];
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                   }
                if (strlen($password)<8) {
                    array_push($errors,"Password must be at least 8 charactes long");
                }
                if ($password!==$confirmPassword) {
                    array_push($errors,"Password does not match");
                }
                require_once("db.php");
                //proverka za sushtestvuvashti danni v db
                $stmt = mysqli_prepare($db, "SELECT * FROM users WHERE email = ? OR phoneNumber = ? OR username = ?");
                mysqli_stmt_bind_param($stmt, "sss", $email, $phoneNumber, $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                mysqli_stmt_close($stmt);
                
                if ($rowCount > 0) {
                    $existingFields = array();
                    $stmt = mysqli_prepare($db, "SELECT email, phoneNumber, username FROM users WHERE email = ? OR phoneNumber = ? OR username = ?");
                    mysqli_stmt_bind_param($stmt, "sss", $email, $phoneNumber, $username);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $existingEmail, $existingPhoneNumber, $existingUsername);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                
                    if ($existingEmail == $email) {
                        array_push($existingFields, "Email");
                    }
                
                    if ($existingPhoneNumber == $phoneNumber) {
                        array_push($existingFields, "Phone Number");
                    }
                
                    if ($existingUsername == $username) {
                        array_push($existingFields, "Username");
                    }
                
                    $errorMessage = "The following fields already exist: " . implode(", ", $existingFields);
                    array_push($errors, $errorMessage);
                }
                
                if (count($errors)>0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert-warning'>$error</div>";
                    }
                } else {
                    $sql = "INSERT INTO users (fullName, phoneNumber, email, address, username, password, role ) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($db);
                    $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt,"sssssss",$fullName, $phoneNumber, $email, $address, $username, $passwordHash, $role);
                        mysqli_stmt_execute($stmt);
                    echo "<div class='alert-success'>You are registered successfully. Please proceed to login.</div>";
                    } else {
                    die("Something went wrong");
                    }
                }
            }
        ?>
        <form action="registration.php" method="post" class="registration__form">
            <h1>Signup</h1>
            <div class="input-box">
                <input type="text" name="fullName" placeholder="Full Name" required>
            </div>
            <div class="input-box">
                <input type="text" name="phoneNumber" placeholder="Phone Number" pattern="[0-9]{10}" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-box">
                <input type="text" name="address" placeholder="Address" required>
            </div>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" minlength="7" maxlength="15" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="input-box role">
                <label for="role" id="role">Choose a role:</label>
                <select name="role">
                    <option value="parent">Parent</option>
                    <option value="nanny">Nanny</option>
                </select>
            </div>
            <div class="btn__holder">
            <input type="submit" class="btn" name="submit" value="Signup">
            </div>
            <div class="register-link">Already have an account? <a href="index.php">Login</a></div>
        </form>
    </div>
    <script src="app.js"></script>
</body>
</html>
