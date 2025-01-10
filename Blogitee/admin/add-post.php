<?php
include 'partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = isset($_SESSION['add-post-data']['title']) ? htmlspecialchars($_SESSION['add-post-data']['title'], ENT_QUOTES, 'UTF-8') : null;
$body = isset($_SESSION['add-post-data']['body']) ? htmlspecialchars($_SESSION['add-post-data']['body'], ENT_QUOTES, 'UTF-8') : null;
$selected_category = isset($_SESSION['add-post-data']['category']) ? $_SESSION['add-post-data']['category'] : null;
$is_featured = isset($_SESSION['add-post-data']['is_featured']) ? $_SESSION['add-post-data']['is_featured'] : null;
// delete form data session
// delete form data session
unset($_SESSION['add-post-data']);
?>
    <section class="form_section"> 
        <div class="container form_container">
            <h2>Add Post</h2>
            <!-- Error Display  --> 
            <?php if (isset($_SESSION['add-post'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['add-post']; ?>
                        <?php unset($_SESSION['add-post']); ?>
                    </p>
                </div>
            <?php endif; ?>
            <!--  END OF ERROR DISPLAY -->
            <form action="<?= ROOT_URL ?>admin/add-post-process.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <select name="category">
                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $selected_category ? 'selected' : '' ?>><?= $category['title'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="10" name="body" placeholder="Body"><?= $body ?></textarea>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <div class="form_control inline">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= $is_featured ? 'checked' : '' ?>>
                        <label for="is_featured">Featured</label>
                    </div>
                <?php endif ?>
                <div class="form_control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Post</button>
            </form>
        </div>
    </section>

<?php
include '../partials/footer.php';
?>
