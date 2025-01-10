<?php
// HHTP ERROR 500 is Server-side error and will overlap the detail, this code is to display the detail error 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// End of detailed error message 

require 'constants.php';

$connection = mysqli_connect($hostname, $username, $password, $dbname);

if (mysqli_errno($connection)) {
    die(mysqli_error($connection));
}