<?php
include 'partials/header.php';

// Fetch post from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); // Sanitize the input to ensure it's a valid integer
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC"; // Query to fetch the post with the specified id
    $posts = mysqli_query($connection, $query); // Execute the query
} else {
    // If id is not set, redirect to the blog page
    header('Location: ' . ROOT_URL . 'blog.php');
    die(); // Terminate script execution
}
?>

<header class="category_title">
    <h2>
        <?php
            // fetch category from categories table using category_id of post
            $category_id = $id; 
            $category_query = "SELECT * FROM categories WHERE id=$id";
            $category_result = mysqli_query($connection, $category_query);
            $category = mysqli_fetch_assoc($category_result);
            echo $category['title'];
        ?>
    </h2>
</header>
<!-- =====================POSTS SECTION======================== -->
<section class="post"> 
        <div class="container post_container">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?> 
                <article>
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?> ">
                    </div>
                    <div class="post_info"> 
                        <h3 class="post_tile">
                            <a href="post.php?id=<?= $post['id'] ?>"><?= substr($post['title'],0,75) ?>...</a>
                        </h3>
                        <p>
                            <?= substr($post['body'],0,200) ?>...
                        </p>
                        <?php
                            // fetch author from users table using author_id
                            $author_id = $post['author_id'];
                            $author_query = "SELECT * FROM users WHERE id=$author_id";
                            $author_result = mysqli_query($connection, $author_query);
                            $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post_author">
                            <div class="post_author_profile">
                                <img src="./images/<?= $author['avatar'] ?>">
                            </div>
                            <div class="post_author_info">
                                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article> 
            <?php endwhile ?>
        </div>
</section> 
<!-- =====================END OF POSTS SECTION======================== -->

<!-- =====================CATEGORIES SECTION======================== -->
<section class="categories">
    <div class="container category_container">
        <?php
        // Query to fetch all categories from the database
        $all_categories_query = "SELECT * FROM categories";
        $all_categories = mysqli_query($connection, $all_categories_query);
        ?>

        <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
            <!-- Generate a button for each category -->
            <a href="<?= ROOT_URL ?>category.php?id=<?= $category['id'] ?>"
            class="category_button"><?= $category['title'] ?></a>
        <?php endwhile ?> 
    </div>
</section>
<!-- =====================END OF CATEGORY SECTION======================== -->  
     


<?php
include 'partials/footer.php';
?>