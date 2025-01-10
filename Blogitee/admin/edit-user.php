<?php
include 'partials/header.php';

// Ensuring edit page only populated when "edit" is clicked (with an ID to access the page, without ID manage-users page will be bounced!)
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // Fetch user name to display on edit form -> easier to edit 
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>
    <section class="form_section">
        <div class="container form_container">
            <h2>Edit User</h2>
            <form action="<?= ROOT_URL ?>admin/edit-user-process.php" method="POST">
                <!-- A hidden field lets web developers include data that cannot be seen or modified by users when a form is submitted.
                     A hidden field often stores what database record that needs to be updated when the form is submitted. -->
                <input type="hidden" value="<?= $user['id'] ?>" name="id">
                <!-- Hidden input with id is bad idea (security-wise ) -->
                <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="First Name">
                <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Last Name">
                <select name="userrole">
                    <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Author</option>
                    <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
                </select> 
                <button type="submit" name="submit" class="btn"> Update User </button>
            </form>
        </div>
    </section>


<?php
include '../partials/footer.php';
?>