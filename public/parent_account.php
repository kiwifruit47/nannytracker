<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nanny Tracker</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/parents.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar__container">
            <a href="parent_account.php">
                <img src="/images/logo.png" alt="Logo" id="navbar__logo">
            </a>
            <div class="message-menu">
                <img src="/images/chat-solid-24.png" alt="messages" id="message__icon">
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
                    <a href="/" class="navbar__links">Profile</a>
                </li>
                <li class="navbar__item">
                    <a href="/" class="navbar__links">Log out</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <h1>Nanny Tracker</h1>
    <div class="grid_container">
        <button class="profile_action_btn connect_with_nanny"><a href="connect_nanny.php" style="text-decoration: none; background-color: inherit; color: #192C4F;">Connect with nanny</a></button>
        <button class="profile_action_btn edit_profile">Edit profile</button>
        <button class="profile_action_btn add_child">Add child</button>
        <button class="profile_action_btn view_calendar">View activity calendar</button>
    </div>
    <script src="app.js"></script>
</body>
</html>