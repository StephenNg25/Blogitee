<?php 
require 'config/constants.php';

// Get back form  data if there was a registration error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
// delete signup data
unset($_SESSION['signup-data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>PHP & MySQL Blog Website    </title>
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
            <h2 style="margin-bottom: 1.5rem;">Sign Up</h2>
            <?php if ($_SESSION['signup']) : ?>
                <div class="alert_message error" style="margin-bottom: 2rem;">
                    <p>
                        <?= $_SESSION['signup'];
                        unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signup-process.php" enctype="multipart/form-data" method="POST">
                <div class="input-field">
                    <input type="text" name="firstname" value="<?= $firstname ?>" required>
                    <label for="">First Name</label>
                </div>

                <div class="input-field">
                    <input type="text" name="lastname" value="<?= $lastname ?>" required>
                    <label for="">Last Name</label>
                </div>

                <div class="input-field">
                    <input type="text" name="username" value="<?= $username ?>" required>
                    <label for="">Username</label>
                </div>

                <div class="input-field">
                    <input type="email" name="email" value="<?= $email ?>" required>
                    <label for="">Email</label>
                </div>

                <div class="input-field">
                    <input type="password" name="createpassword" value="<?= $createpassword ?>" required>
                    <label for="">Create Password</label>
                </div>

                <div class="input-field">
                    <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" required>
                    <label for="">Confirm Password</label>
                </div>
                <div class="avatar-field">
                    <input type="file" name="avatar" id="avatar" required>
                    <label for="avatar">Upload Avatar</label>
                </div>
                <button type="submit" name="submit" class="btn"> Sign Up</button>
                <small>
                    Already have an account? <a href="signin.php">Sign In</a>
                </small>
            </form>
        </div>
    </section>

</body>
</html>