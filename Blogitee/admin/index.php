<?php
include 'partials/header.php';

// fetch current user's posts from database
$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY      id DESC";
$posts = mysqli_query($connection, $query);
?>
    <section class="dashboard">
        <?php if (isset($_SESSION['add-post-success'])) : // success message for post added?> 
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['add-post-success']; 
                    unset($_SESSION['add-post-success']); 
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['edit-post-success'])) : // success message for post editted ?> 
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['edit-post-success']; 
                    unset($_SESSION['edit-post-success']); 
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['edit-post'])) : // error message for editting post ?> 
            <div class="alert_message error container">
                <p style="text-align: center;">
                    <?= $_SESSION['edit-post']; 
                    unset($_SESSION['edit-post']); 
                    ?>
                </p>
        </div>
        <?php elseif (isset($_SESSION['delete-post-success'])) : ?> <!-- Show if post is deleteted successfully  -->
            <div class="alert_message success container">
                <p style="text-align: center;">
                    <?= $_SESSION['delete-post-success']; ?>
                    <?php unset($_SESSION['delete-post-success']); ?>
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
                        <a href="index.php" class="active"><i class="uil uil-postcard"></i>
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
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <?php endif ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Posts</h2>
                <?php if(mysqli_num_rows($posts) > 0) :?> <!-- Checking if there's any existed other users in database --> 
                <table>
                    <thread>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thread>
                    <tbody>  
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table -->
                            <?php // This block of code is necessarily could be removed by joning the table in database
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $category['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                <!-- Delete Button with Confirmation -->
                                <td>
                                    <a href="#" 
                                    class="btn sm danger delete-btn"
                                    data-type="post" 
                                    data-url="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>">
                                    Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <?php else : ?>
                    <div class="alert_message error">
                        <p style="text-align: center;">
                            <?= "No posts found" ?>
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
