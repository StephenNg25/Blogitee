<?php
include 'partials/header.php';

// Get back form data if there was an error
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;
$userrole = $_SESSION['add-user-data']['userrole'] ?? null;

// Delete session data
unset($_SESSION['add-user-data']);

?> 
    <section class="form_section">
        <div class="container form_container"> 
            <h2>Add User</h2>
            <!-- Error Display  -->
            <?php if (isset($_SESSION['add-user'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['add-user']; ?>
                        <?php unset($_SESSION['add-user']); ?>
                    </p>
                </div>
            <?php endif; ?>
            <!--  END OF ERROR DISPLAY -->
            <form action="<?= ROOT_URL ?>admin/add-user-process.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
                <select name="userrole">
                    <option value="0" <?= $userrole === "0" ? 'selected' : '' ?>>Author</option>
                    <option value="1" <?= $userrole === "1" ? 'selected' : '' ?>>Admin</option>
                </select>

                <div class="form_control">
                    <label for="avatar" style="color: #fbe9d0">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Add User</button>
            </form>
        </div>
    </section>

<?php  
include '../partials/footer.php';
?>
