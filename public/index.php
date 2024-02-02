<?php
include('db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $user = mysqli_fetch_assoc($result);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                if ($user['role'] == 'parent') {
                    header("Location: parent_account.php");
                } elseif ($user['role'] == 'nanny') {
                    header("Location: nanny_account.php");
                }
                exit();
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "Error in database query";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error in prepared statement";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nanny Tracker</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
</head>
<body>
    <!-- Navbar Section -->
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
    <!-- Hero Section -->
    <div class="main">
        <div class="main__container">
            <div class="main__content">
                <h1>Nanny Tracker</h1>
                <h2>Your Child's Day, Your Way: Keeping You Connected Every Step of the Way</h2>
                <p>Choose NannyTracker for a seamless childcare experience! Our app offers real-time updates on your child's activities, secure communication with your babysitter, and an intuitive calendar for effortless scheduling. Stay connected, informed, and in control.</p>
            </div>
            <div class="login__wrapper">
            
                <form action="index.php" method="post" class="login__form">
                    <h1>Login</h1>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="register-link">Don't have an account? <a href="registration.php">Register</a></div>
                </form>
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>