<?php
require 'config/database.php';

// Get signup form data if signup button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    
    // Validate input values
    if (!$createpassword || !$confirmpassword) {
        $_SESSION['signup'] = "Please enter your password !";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Password should be 8+ characters !";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Please add an avatar !";
    } else {
        // Check if passwords don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match !";
        } else {
            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exist in the database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exist";
            } else {
                // WORK ON AVATAR
                // Rename avatar
                $time = time(); // Make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                // Make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);

                if (in_array($extension, $allowed_files)) {
                    // Make sure image is not too large (1MB+)
                    if ($avatar['size'] < 1000000) {
                        
                        // Upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = "File size too big. Should be less than 1MB";
                    }
                } else {
                    $_SESSION['signup'] = "File should be png, jpg, or jpeg";
                }
            }
        }
    }

    // Redirect back to signup page if there was any problem
    if (isset($_SESSION['signup'])) {
        // Pass form data back to signup page (So when page refreshs due to input error, previous valid input still remains )
        $_SESSION['signup-data'] = $_POST; 
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // Insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
                            VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        
        if (!mysqli_errno($connection)) {
            unset($_SESSION['signin-data']); // Ensure previous signin-data is cleared
            unset($_SESSION['signup-data']); // Clear signup data as well
            
            // Redirect to login page with success message
            $_SESSION['signup-success'] = "Registration successful. Please log in !";
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }   


} else {
    // If the button wasn't clicked, redirect back to the signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
