<?php
include 'partials/header.php';

// fetch all posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC ";
$posts = mysqli_query($connection, $query);
?>

<section class="search_bar">
    <form class="container search_container" action="search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Search">
        </div>
        <button type="submit" name="submit" class="btn">GO</button>
    </form>
</section>

<!-- =====================END OF SEARCH BAR======================== -->

<!-- =====================POSTS SECTION======================== --> 
<section class="post <?= $featured ? '' : 'section_extra-margin' ?>"> 
    <div class="container post_container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?> 
            <article>
                <div class="post_thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?> ">
                </div>
                <div class="post_info">
                    <?php
                        // fetch category from categories table using category_id of post
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <a href="category.php?id=<?= $post['id'] ?>" class="category_button"><?= $category['title'] ?></a>
                    <h3 class="post_tile">
                        <a href="post.php?id=<?= $post['id'] ?>"><?= $post['title']?></a>
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