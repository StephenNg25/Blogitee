<?php
include 'partials/header.php';

// Retrieve and sanitize the search query
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

// Preprocess the search query to remove special characters and split into words
$search_keywords = array_filter(preg_split('/[^a-zA-Z0-9]+/', strtolower($search_query)));

if (!empty($search_keywords)) {
    // Build a dynamic SQL query to match any word in the title or category
    $conditions = [];
    foreach ($search_keywords as $keyword) {
        $conditions[] = "LOWER(p.title) LIKE '%$keyword%' OR LOWER(c.title) LIKE '%$keyword%'";
    }
    $conditions_sql = implode(' OR ', $conditions);

    $query = "
        SELECT p.*, c.title AS category_title, u.firstname, u.lastname, u.avatar 
        FROM posts p
        INNER JOIN categories c ON p.category_id = c.id
        INNER JOIN users u ON p.author_id = u.id
        WHERE $conditions_sql
        ORDER BY p.date_time DESC
    ";
} else {
    // Redirect back to blog.php if no valid search query is provided
    header("Location: blog.php");
    exit();
}

$posts = mysqli_query($connection, $query);
?>

<section class="search_bar">
    <form class="container search_container" action="search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Search" value="<?= htmlspecialchars($search_query) ?>" required>
        </div>
        <button type="submit" name="submit" class="btn">GO</button>
    </form>
</section>

<!-- Display error message if no results -->
<?php if (mysqli_num_rows($posts) == 0): ?>
    <div class="alert_message error container" style="margin-top: 5rem;">
        <p style="text-align: center;">
            No results found for "<?= htmlspecialchars($search_query) ?>".
        </p>
    </div>
<?php endif; ?>

<!-- =====================POSTS SECTION======================== --> 
<section class="post">
    <div class="container post_container">
        <?php if (mysqli_num_rows($posts) > 0): ?>
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article>
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="<?= $post['title'] ?>">
                    </div>
                    <div class="post_info">
                        <?php
                            // fetch category from categories table using category_id of post
                            $category_id = $post['category_id'];
                            $category_query = "SELECT * FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="category.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
                        <h3 class="post_title">
                            <a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p>
                            <?= substr($post['body'], 0, 200) ?>...
                        </p>
                        <div class="post_author">
                            <div class="post_author_profile">
                                <img src="./images/<?= $post['avatar'] ?>" alt="<?= $post['firstname'] . ' ' . $post['lastname'] ?>">
                            </div>
                            <div class="post_author_info">
                                <h5>By: <?= "{$post['firstname']} {$post['lastname']}" ?></h5>
                                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
<!-- =====================END OF POSTS SECTION======================== -->

<!-- =====================CATEGORIES SECTION======================== -->
<section class="categories">
    <div class="container category_container">
        <?php
        // Fetch all categories for the category section
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = mysqli_query($connection, $all_categories_query);
        ?>

        <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
            <a href="<?= ROOT_URL ?>category.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>
<!-- =====================END OF CATEGORY SECTION======================== -->

<?php
include 'partials/footer.php';
?>
