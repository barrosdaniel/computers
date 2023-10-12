<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Lodgement System | Login</title>
</head>

<body>
    <h1>Login</h1>

    <?php
    echo <<<END
        <form action="home.php" method="POST">
            <p>Username: <input type="text" name="username"></p>
            <p>Password: <input type="password" name="password"></p>
            <p><input type="submit" name="submit" value="Log In"></p>
        </form>
    END;
    include "footer_logged_out.php";
    ?>

</body>

</html>