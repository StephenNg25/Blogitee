<?php 
require 'config/constants.php';

$username_email = $_SESSION[ 'signin-data']['username_email'] ?? null;
$password = $_SESSION[ 'signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>PHP & MySQL Blog Website</title>
    <!-- STYLESHEET -->
    <link rel="stylesheet" href="style.css">
    <!-- ICONSCOUT -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form_section">
        <div class="container form_container">
            <h2>Sign In</h2>
            <p style="margin-bottom: 1.5rem; color: gray;">For the best experience, log in using the admin account to explore all features of the app system management. (Username: admin , Password: 123123123)</p>
            <?php if (isset($_SESSION['signup-success'])) : ?>
                <div class="alert_message success" style="margin-bottom: 2rem;">
                    <p>
                        <?= $_SESSION['signup-success']; ?>
                        <?php unset($_SESSION['signup-success']); ?>
                    </p>
                </div>
            <?php elseif (isset($_SESSION['signin'])) : ?>
                <div class="alert_message error" style="margin-bottom: 2rem;">
                    <p>
                        <?= $_SESSION['signin']; ?>
                        <?php unset($_SESSION['signin']); ?>
                    </p>
                </div>
            <?php endif ?>

            <form action="<?= ROOT_URL ?>signin-process.php" method="POST">
                <div class="input-field">
                    <input type="text" name="username_email" value="<?= $username_email ?>" required>
                    <label for="">Username or Email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" value="<?= $password ?>" required>
                    <label for="">Password</label>
                </div>
                <button type="submit" name="submit" class="btn"> Sign In</button>
                <small> 
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </small>
            </form>
        </div>
    </section>

</body>
</html>