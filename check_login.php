<?php
if (isset($_POST['username']) || isset($_POST['password'])) {
    // Form input validation
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        echo '<p style="color: red;">Username not supplied.</p>';
        return false;
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        echo '<p style="color: red;">Password not supplied.</p>';
        return false;
    }

    require "db_connection.php";

    // Get form values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials
    $query = "SELECT count(*) 
              FROM authorized_users 
              WHERE username = ? AND password = sha1(?)";
    $statement = $db->prepare($query);
    $statement->bind_param("ss", $username, $password);
    $statement->execute();
    $result = $statement->get_result();
    $statement->close();

    // Unsuccessful login check
    if (!$result) {
        echo "ERROR: Could not check credentials.";
        $db->close();
        exit;
    }

    $row = $result->fetch_row();
    if ($row[0] > 0) {
        // Successful login
        $_SESSION['valid_user'] = $username;
        $db->close();
        return true;
    } else {
        // Failed login
        echo '<p style="color: red;">Username and password incorrect.</p>';
        $db->close();
        return false;
    }
}
return false;
