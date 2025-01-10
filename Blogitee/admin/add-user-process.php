<?php
require '../config/database.php';

// Get form data if submit  button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    
    // Validate input values
    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your First Name !";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Please enter your Last Name !";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Please enter your Username !";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please enter a valid email !";
    } elseif (!$createpassword || !$confirmpassword) {
        $_SESSION['add-user'] = "Please enter your password !";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "Password should be 8+ characters !";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please add an avatar !";
    } else {
        // Check if passwords don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "Passwords do not match !";
        } else {
            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exist in the database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or Email already exist";
            } else {
                // WORK ON AVATAR
                // Rename avatar
                $time = time(); // Make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

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
                        $_SESSION['add-user'] = "File size too big. Should be less than 1MB";
                    }
                } else {
                    $_SESSION['add-user'] = "File should be png, jpg, or jpeg";
                }
            }
        }
    }

    // Redirect back to add-user page if there was any problem
    if (isset($_SESSION['add-user'])) {
        // Pass form data back to add-user page (So when page refreshs due to input error, previous valid input still remains )
        $_SESSION[ 'add-user-data'] = $_POST; 
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        // Insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
                            VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin')";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        
        if (!mysqli_errno($connection)) { 
            // unset($_SESSION['add-user-data']); // Clear add-user-data as well
            
            // Redirect to to manage-users page with sucessful message !
            $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully.";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }    
} else {
    // If the button wasn't clicked, redirect back to the signup page (this trying to prevent user from trying to enter result page by url)
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}
