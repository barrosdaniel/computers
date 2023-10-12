<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Lodgement System | Home</title>
</head>

<body>
    <h1>Job Lodgement</h1>

    <?php
    session_start();
    $validSession = require "check_session.php";

    $validLogin = require "check_login.php";

    if ($validLogin || $validSession) {
        $username = $_SESSION['valid_user'];
        echo "<h4>Welcome, $username<h4>";
        echo "<h2>Your options:</h2>";
        echo '<a href="">View All Jobs</a><br>';
        echo '<a href="">Add a Job</a><br>';
        include "footer_logged_in.php";
    } else {
        echo "You are not logged in<br>";
        echo "<h2>Your options:</h2>";
        echo '<a href="">Add a Job</a><br>';
        include "footer_logged_out.php";
    }
    ?>

</body>

</html>