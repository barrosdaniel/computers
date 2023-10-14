<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Lodgement System | Edit Job</title>
</head>

<body>
    <h1>Edit Job</h1>

    <?php
    require "db_connection.php";

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "ERROR: Job ID not supplied.";
        $db->close();
        exit;
    }
    $id = $_GET['id'];



    ?>

</body>

</html>