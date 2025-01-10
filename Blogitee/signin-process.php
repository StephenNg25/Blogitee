<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    // Fetch user from database
    $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);

    if (mysqli_num_rows($fetch_user_result) == 1) {
        // Convert the record into an associative array
        $user_record = mysqli_fetch_assoc($fetch_user_result);
        $db_password = $user_record['password'];
    
        // Compare form password with database password
        if (password_verify($password, $db_password)) {
            // Set session for access control
            $_SESSION['user-id'] = $user_record['id'];
    
            // Set session if user is an admin
            if ($user_record['is_admin'] == 1) {
                $_SESSION['user_is_admin'] = true;
            }
            // Log user in
            header('location: ' . ROOT_URL . 'admin/');
        } else {
            $_SESSION['signin'] = "Wrong Password. Try Again!";
        }
    } else {
        $_SESSION['signin'] = "User/Emailf not found";
    }
    

    // If any problem, redirect back to signin page with login data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
