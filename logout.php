<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Lodgement System | Log Out</title>
</head>

<body>
    <?php
    // Session control
    session_start();
    $validSession = require "check_session.php";

    // If user is logged in, log them out
    if ($validSession) {
        $oldUser = $_SESSION['valid_user'];
        unset($_SESSION['valid_user']);
        session_destroy();
    }

    // Display logout message
    if (!empty($oldUser)) {
        echo "Logged out<br>";
    } else {
        echo "You were not logged in.<br><br>";
    }

    include "footer_logged_out.php";
    ?>

</body>

</html>