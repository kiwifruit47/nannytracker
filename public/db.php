<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "nannytracker";
$db = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$db) {
    die("Something went wrong;");
}
?>