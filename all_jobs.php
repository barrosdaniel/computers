<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
        }

        .sort-selection {
            margin-bottom: 16px;
        }
    </style>
    <title>Job Lodgement System | All Jobs</title>
</head>

<body>
    <h1>List of Jobs</h1>

    <form action="all_jobs.php" method="GET" class="sort-selection">
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort">
            <option value="customer_name">Customer Name</option>
            <option value="severity">Severity</option>
        </select>
        <input type="submit" value="Go">
    </form>

    <?php
    session_start();
    $validLogin = require "check_login.php";
    $validSession = require "check_session.php";

    if (!$validLogin && !$validSession) {
        header("Location: login.php");
        exit;
    }

    require "db_connection.php";

    $query = "SELECT * 
              FROM jobs 
              ORDER BY customer_name";
    if (isset($_GET['sort']) && $_GET['sort'] == "severity") {
        $query = "SELECT * 
                  FROM jobs 
                  ORDER BY severity";
    }

    $statement = $db->prepare($query);
    $result = $db->query($query);
    $numResults = $result->num_rows;
    ?>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Severity</th>
                <th>Description</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < $numResults; $i++) {
                $row = $result->fetch_assoc();
                $id = $row['id'];
                $customer_name = $row['customer_name'];
                $email = $row['email'];
                $severity = $row['severity'];
                $description = $row['description'];
                echo "<tr>";
                echo "<td>$customer_name</td>";
                echo "<td>$email</td>";
                switch ($severity) {
                    case 1:
                        $severity = "High";
                        break;
                    case 2:
                        $severity = "Medium";
                        break;
                    case 3:
                        $severity = "Low";
                        break;
                    default:
                        $severity = "Unknown";
                }
                echo "<td>$severity</td>";
                echo "<td>$description</td>";
                createButton("id", $id, "Edit", "edit.php");
                createButton("id", $id, "Delete", "delete.php");
                echo "</tr>";
            }

            $result->free();
            $db->close();

            function createButton($hiddenName, $hiddenValue, $buttonText, $actionPage)
            {
                echo <<<END
                    <td>
                        <form action="$actionPage" method="GET">
                            <input type="hidden" name="$hiddenName" value="$hiddenValue">
                            <input type="submit" value="$buttonText">
                            </form>
                            </td>
                END;
            }
            ?>
        </tbody>
    </table>

    <?php
    include "footer_logged_in.php";
    ?>
</body>

</html>