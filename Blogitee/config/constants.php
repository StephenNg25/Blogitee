<?php
// a global constant that holds root_url, which could be called in other files to access different pages
// since pages are now scattered everywhere with different folders  
session_start();  
define('ROOT_URL', getenv('ROOT_URL') ?: 'http://localhost/blogitee/');

// Fetch and validate critical environment variables
$hostname = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');