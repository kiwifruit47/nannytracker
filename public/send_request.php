<?php
session_start();
include 'db.php';

$nannyId = $_POST['nannyId'];
$selectedDate = $_POST['dates'];

$nannyId = mysqli_real_escape_string($db, $nannyId);
$selectedDate = mysqli_real_escape_string($db, $selectedDate);

$query = "INSERT INTO nanny_requests (nanny_id, selected_date) VALUES ('$nannyId', '$selectedDate')";
$result = mysqli_query($db, $query);

if ($result) {
    echo 'Request successfully sent!';
} else {
    echo 'Error sending request. Please try again.';
}
?>