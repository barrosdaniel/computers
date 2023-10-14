<?php
// DB connection secrets
$dbAddress = 'localhost:3307';
$dbUser = 'webauth';
$dbPass = 'webauth';
$dbName = 'computer';

// DB connection
$db = new mysqli($dbAddress, $dbUser, $dbPass, $dbName);

// Connection errors
if ($db->connect_error) {
    echo "Could not connect to the database. Please try again later.";
    exit;
}
