<?php
include 'partials/header.php';

// Fetch users from database but not the current user
$current_admin_id = $_SESSION['user-id'];
$query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
$users = mysqli_query($connection, $query);

?>  
    <section class="dashboard">
        <!--  SUCCESSFUL MESSAGES DISPLAY -->
        <?php if (isset($_SESSION['add-user-success'])) : ?> <!-- Show if user is added successfully  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['add-user-success']; ?>
                    <?php unset($_SESSION['add-user-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['edit-user-success'])) : ?> <!-- Show if user is editted successfully  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['edit-user-success']; ?>
                    <?php unset($_SESSION['edit-user-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['edit-user'])) : ?> <!-- Show if user is editted unsuccessfully  -->
            <div class="alert_message error container">
                <p style="text-align: center;">
                    <?= $_SESSION['edit-user']; ?>
                    <?php unset($_SESSION['edit-user']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['delete-user-success'])) : ?> <!-- Show if user is deleteted successfully  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['delete-user-success']; ?>
                    <?php unset($_SESSION['delete-user-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['delete-user'])) : ?> <!-- Show if user is deleteted unsuccessfully  -->
            <div class="alert_message error container">
                <p style="text-align: center;">
                    <?= $_SESSION['delete-user']; ?>
                    <?php unset($_SESSION['delete-user']); ?>
                </p>
            </div>
        <?php endif ?>
        <!-- END OF SUCCESSFUL MESSAGES DISPLAY -->

        <div class="container dashboard_container">
            <button id="show_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-right-b"></i></button>
            <button id="hide_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-left-b"></i></button>
            <aside>
                <ul>
                    <li>
                        <a href="add-post.php"><i class="uil uil-pen"></i>
                            <h5>Add Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="index.php"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>

                    <!-- This following part only displayed for admin user -->
                    <?php if(isset($_SESSION['user_is_admin'])): ?>  
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <?php endif ?>
                    <!-- END OF ADMIN USER FUNCTIONS  -->
                </ul>
            </aside>
            <main>
                <h2>Manage Users</h2>
                <?php if(mysqli_num_rows($users) > 0) :?> <!-- Checking if there's any existed other users in database -->
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                            <!-- Only fetch the rest of all users except for the current one -->
                            <tr>
                                <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                                <!-- Delete Button with Confirmation -->
                                <td>
                                    <a href="#" 
                                    class="btn sm danger delete-btn"
                                    data-type="user" 
                                    data-url="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>">
                                    Delete
                                    </a>
                                </td>
                                <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <!-- If there's nothing found in database other than the current user, display an empty message -->
                <?php else : ?>
                    <div class="alert_message error">
                        <p style="text-align: center;">
                            <?= "No users found" ?>
                        </p>
                    </div>
                <?php endif ?>
            </main>
        </div>
    </section>

    <!-- Confirmation Dialog -->
    <div id="confirmation-dialog" class="dialog hidden">
        <div class="dialog-content">
            <p>Are you sure you want to delete this <span id="delete-type"></span>?</p>
            <div class="dialog-actions">
                <button id="cancel-button" class="btn sm">No</button>
                <a id="confirm-link" class="btn sm danger" href="#">Yes</a>
            </div>
        </div>
    </div>
    <script src="delete.js"></script>
    <!-- End of Confirmation Dialog -->


<?php
include '../partials/footer.php';
?>