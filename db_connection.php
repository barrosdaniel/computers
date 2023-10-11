<?php
$dbAddress = 'localhost:3307';
$dbUser = 'webauth';
$dbPass = 'webauth';
$dbName = 'computer';

$db = new mysqli($dbAddress, $dbUser, $dbPass, $dbName);

if ($db->connect_error) {
    echo "Could not connect to the database. Please try again later.";
    exit;
}
