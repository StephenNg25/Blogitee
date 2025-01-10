<?php
include 'partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories ORDER BY title ASC"; // ascendant order 
$categories = mysqli_query($connection, $query);
?>
    <section class="dashboard">
    
        <?php if (isset($_SESSION['add-category-success'])) : ?> <!-- Show if ADD CATEGORY was successful  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['add-category-success']; ?>
                    <?php unset($_SESSION['add-category-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['add-category'])) : ?> <!-- Show if CATEGORY FAILED to be added -->
            <div class="alert_message error container">
                <p style="text-align: center;">
                    <?= $_SESSION['add-category']; ?>
                    <?php unset($_SESSION['add-category']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['edit-category'])) : ?>    <!-- Show if EDIT CATEGORY was NOT successful  -->
            <div class="alert_message error container">
                <p style="text-align: center;">
                    <?= $_SESSION['edit-category']; ?>
                    <?php unset($_SESSION['edit-category']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['edit-category-success'])) : ?>  <!-- Show if EDIT CATEGORY was successful  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['edit-category-success']; ?>
                    <?php unset($_SESSION['edit-category-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['delete-category-success'])) : ?> <!-- Show if category is deleteted successfully  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['delete-category-success']; ?>
                    <?php unset($_SESSION['delete-category-success']); ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['delete-category'])) : ?> <!-- Show if category is deleteted unsuccessfully  -->
            <div class="alert_message error container">
                <p style="text-align: center;">
                    <?= $_SESSION['delete-category']; ?>
                    <?php unset($_SESSION['delete-category']); ?>
                </p>
            </div>
        <?php endif ?>

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
                    <?php if(isset($_SESSION['user_is_admin'])): ?>  
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <?php endif ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Categories</h2>
                <?php if(mysqli_num_rows($categories) > 0) :?> <!-- Checking if there's any existed category  in database -->
                <table>
                    <thread>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thread>
                    <tbody>
                        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                            <tr>
                                <td><?= $category['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                                <!-- Delete Button with Confirmation -->
                                <td>
                                    <a href="#" 
                                    class="btn sm danger delete-btn"
                                    data-type="category" 
                                    data-url="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>">
                                    Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <!-- If there's nothing found in database, display an empty message -->
                <?php else : ?>
                    <div class="alert_message error">
                        <p style="text-align: center;">
                            <?= "No categories found" ?>
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
