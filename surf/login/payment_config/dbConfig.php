<?php

$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName     = 'payment';

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}