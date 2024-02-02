<?php
session_start();
include 'db.php';

$query = "SELECT nannies.id AS nanny_id, users.username, nannies.description
          FROM nannies
          INNER JOIN users ON nannies.user_id = users.id";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NannyTracker</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/request_nanny.css">
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

    <!-- Nannies List Container -->
    <div class="nannies__container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="nanny">';
            echo '<h3>' . $row['username'] . '</h3>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<button class="request-btn btn" data-nanny-id="' . $row['nanny_id'] . '">Request</button>';
            echo '</div>';
            echo '<div id="dialog-' . $row['nanny_id'] . '" title="Select Date">';
            echo '<div class="date-range-picker" id="date-range-picker-' . $row['nanny_id'] . '"></div>';
            echo '</div>';
            echo '<hr>';
        }
        ?>
    </div>
    <script>
    $(function() {
        $('.request-btn').click(function() {
            var nannyId = $(this).data('nanny-id');
            $('#dialog-' + nannyId).dialog({
                width: 350,
                modal: true,
                resizable: false,
                buttons: {
                    "Submit Request": function() {
                        let selectedDate = $('#date-range-picker-' + nannyId).val();
                        $.ajax({
                            method: 'POST',
                            url: 'send_request.php',
                            data: { nannyId: nannyId, dates: selectedDate },
                            success: function(response) {
                                alert(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });

                        $(this).dialog('close');
                    },
                    "Cancel": function() {
                        $(this).dialog('close');
                    }
                },
                open: function() {
                    $('#date-range-picker-' + nannyId).datepicker({
                        dateFormat: 'yy-mm-dd',
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
