<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Lodgement System | Add Job</title>
</head>

<body>
    <h1>Add Job</h1>

    <?php
    // Session control
    session_start();
    $validLogin = require "check_login.php";
    $validSession = require "check_session.php";
    if (!$validLogin && !$validSession) {
        header("Location: login.php");
        exit;
    }

    require "db_connection.php";

    // Form processing
    if (isset($_POST['submit'])) {
        // Get form action
        $submitAction = $_POST['submit'];

        // Cancel button pressed
        if ($submitAction == "Cancel") {
            $db->close();
            header("Location: all_jobs.php");
            exit;
        }

        // Form input validation
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            echo "ERROR: Name not supplied.";
            $db->close();
            exit;
        }
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            echo "ERROR: Email not supplied.";
            $db->close();
            exit;
        }
        if (!isset($_POST['severity']) || empty($_POST['severity'])) {
            echo "ERROR: Severity not supplied.";
            $db->close();
            exit;
        }
        if (!isset($_POST['problem']) || empty($_POST['problem'])) {
            echo "ERROR: Problem description not supplied.";
            $db->close();
            exit;
        }

        // Get form values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $severity = $_POST['severity'];
        $problem = $_POST['problem'];

        // Insert into Database
        $query = "INSERT INTO jobs 
                      (customer_name, email, severity, description) 
                      VALUES (?, ?, ?, ?)";
        $statement = $db->prepare($query);
        $statement->bind_param("ssis", $name, $email, $severity, $problem);
        $statement->execute();
        $affectedRows = $statement->affected_rows;
        $statement->close();
        $db->close();

        // Display message to user
        if ($affectedRows > 0) {
            echo "Job added successfully.<br><br>";
            echo "<a href='all_jobs.php'>Back to List of Jobs</a>";
            echo "<br>";
        } else {
            echo "ERROR: Could not add job.<br><br>";
            echo "<a href='all_jobs.php'>Back to List of Jobs</a><br>";
            echo "<br>";
        }
    } else {
        // Display form
        echo <<<END
        <form action="" method="POST">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" maxlength="32"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" maxlength="64"></td>
            </tr>
            <tr>
                <td>Severity:</td>
                <td>
                    <select name="severity" id="severity">
                        <option value="3">Low</option>
                        <option value="2">Medium</option>
                        <option value="1">High</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Problem Description:</td>
                <td><textarea name="problem" id="problem" cols="60" rows="12" maxlength="128"></textarea></td>
            </tr>
        </table>
        </br>
        <input type="submit" name="submit" value="Add">
        <input type="submit" name="submit" value="Cancel">
        <br><br>
        END;
    }

    include "footer_logged_in.php";
    ?>
</body>

</html>