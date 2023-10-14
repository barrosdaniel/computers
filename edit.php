<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        textarea {
            font-family: inherit;
        }
    </style>
    <title>Job Lodgement System | Edit Job</title>
</head>

<body>
    <h1>Edit Job</h1>

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

    // Validate Job ID
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "ERROR: Job ID not supplied.";
        $db->close();
        exit;
    }

    // Get Job ID
    $id = $_GET['id'];

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
        if (!isset($_POST['description']) || empty($_POST['description'])) {
            echo "ERROR: Problem description not supplied.";
            $db->close();
            exit;
        }

        // Get form values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $severity = $_POST['severity'];
        $description = $_POST['description'];

        // Update Database record
        $query = "UPDATE jobs 
                  SET customer_name = ?, email = ?, severity = ?, description 
                    = ?
                  WHERE id = $id";
        $statement = $db->prepare($query);
        $statement->bind_param("ssis", $name, $email, $severity, $description);
        $statement->execute();
        $affectedRows = $statement->affected_rows;
        $statement->close();
        $db->close();

        // Display message to user
        if ($affectedRows == 1) {
            echo "Job updated successfully.<br><br>";
            echo "<a href='all_jobs.php'>Back to List of Jobs</a>";
            echo "<br>";
        } else {
            echo "ERROR: Could not update job.<br><br>";
            echo "<a href='all_jobs.php'>Back to List of Jobs</a><br>";
            echo "<br>";
        }
    } else {
        // Get Job details
        $queryJobDetails = "SELECT * 
                            FROM jobs 
                            WHERE id = $id";
        $statementJobDetails = $db->prepare($queryJobDetails);
        $statementJobDetails->execute();
        $resultJobDetails = $statementJobDetails->get_result();
        $statementJobDetails->close();
        $rowJobDetails = $resultJobDetails->fetch_assoc();

        $name = $rowJobDetails['customer_name'];
        $email = $rowJobDetails['email'];
        $severity = $rowJobDetails['severity'];
        $description = $rowJobDetails['description'];


        // Display form
        echo <<<END
        <form action="" method="POST">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" maxlength="32" value="$name"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" maxlength="64" value="$email"></td>
            </tr>
            <tr>
                <td>Severity:</td>
                <td>
                    <select name="severity" id="severity">
        END;
        if ($severity == 3) {
            echo '<option value="3" selected>Low</option>';
        } else {
            echo '<option value="3">Low</option>';
        }
        if ($severity == 2) {
            echo '<option value="2" selected>Medium</option>';
        } else {
            echo '<option value="2">Medium</option>';
        }
        if ($severity == 1) {
            echo '<option value="1" selected>High</option>';
        } else {
            echo '<option value="1">High</option>';
        }
        echo <<<END
                    </select>
                </td>
            </tr>
            <tr>
                <td>Problem Description:</td>
                <td><textarea name="description" id="description" cols="60" rows="12"
                    maxlength="128">$description</textarea></td>
            </tr>
        </table>
        </br>
        <input type="submit" name="submit" value="Update">
        <input type="submit" name="submit" value="Cancel">
        <br><br>
        END;

        $resultJobDetails->free();
        $db->close();
    }

    include "footer_logged_in.php";
    ?>
</body>

</html>