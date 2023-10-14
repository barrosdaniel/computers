<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Lodgement System | Delete Job</title>
</head>

<body>
    <h1>Delete Job</h1>

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

        // Delete Database record
        $query = "DELETE FROM jobs 
                  WHERE id = ?";
        $statement = $db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $affectedRows = $statement->affected_rows;
        $statement->close();
        $db->close();

        // Display message to user
        if ($affectedRows == 1) {
            echo "Job deleted successfully.<br><br>";
            echo "<a href='all_jobs.php'>Back to List of Jobs</a>";
            echo "<br>";
        } else {
            echo "ERROR: Could not delete job.<br><br>";
            echo "<a href='all_jobs.php'>Back to List of Jobs</a><br>";
            echo "<br>";
        }
    } else {
        // Get Job details
        $queryJobDetails = "SELECT * 
                            FROM jobs 
                            WHERE id = ?";
        $statementJobDetails = $db->prepare($queryJobDetails);
        $statementJobDetails->bind_param("i", $id);
        $statementJobDetails->execute();
        $resultJobDetails = $statementJobDetails->get_result();
        $statementJobDetails->close();
        $rowJobDetails = $resultJobDetails->fetch_assoc();

        $name = $rowJobDetails['customer_name'];
        $email = $rowJobDetails['email'];
        $severity = $rowJobDetails['severity'];
        $description = $rowJobDetails['description'];

        // Display job details
        echo <<<END
        <form action="" method="POST">
        <table>
            <tr>
                <td>Customer Name:</td>
                <td>$name</td>
            </tr>
            <tr>
                <td>Customer Email:</td>
                <td>$email</td>
            </tr>
            <tr>
                <td>Severity:</td>
        END;
        if ($severity == 1) {
            echo "<td>High</td>";
        } else if ($severity == 2) {
            echo "<td>Medium</td>";
        } else {
            echo "<td>Low</td>";
        }
        echo <<<END
            </tr>
            <tr>
                <td>Description:</td>
                <td>$description</td>
            </tr>
        </table>
        </br>
        <input type="hidden" name="id" value="$id">
        <input type="submit" name="submit" value="Delete">
        <input type="submit" name="submit" value="Cancel">
        </form>
        END;

        $resultJobDetails->free();
        $db->close();
    }

    include "footer_logged_in.php";
    ?>
</body>

</html>