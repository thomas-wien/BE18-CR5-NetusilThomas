<?php

// Defining Constants to use a function also
require_once 'config.inc.php';

$mysqli = new mysqli(HOST, USER, PASS, DB);

if ($mysqli->connect_error) {
    die('Object Orientated Connection failed: ' . mysqli_connect_error());
}
