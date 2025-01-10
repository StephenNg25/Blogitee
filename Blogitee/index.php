<?php
include 'partials/header.php';
// fetch featured post from database
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// fetch 9 posts from posts table
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $query);
?>
<h1><b style="color: #FF6347;">Welcome to <b style="color: #FFD700;;">Blogiteee!</b></b style="color: #FF6347;"> Feel free to discover any stories and create your own with creative ideas.</h1>
<!-- =====================FEATURED SECTION======================== -->
<?php if (mysqli_num_rows ($featured_result) == 1) : ?>
    <section class="featured"> 
        <!-- this section will contain 1 div for whole, 2 div for the left thumbnail and the right block of information 
            which includes catergory button, title (clickable), paragrph, a div for author profile and date of blog updated  -->
        <div class="container featured_container">
            <div class="post_thumbnail">
                <img src="./images/<?= $featured['thumbnail'] ?> ">
            </div>
            <div class="post_info">
                <?php
                    // fetch category from categories table using category_id of post
                    $category_id = $featured['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                ?>
                <a href="category.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
                <h2 class="post_tile"><a href="post.php?id=<?= $featured['id'] ?>"> <?= $featured['title'] ?></a></h2>
                <p>    
                  <?= substr($featured['body'],0,300) ?>...
                </p>            
                <?php
                    // fetch author from users table using author_id
                    $author_id = $featured['author_id'];
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
                        <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<!-- =====================END OF FEATURED SECTION======================== -->

<!-- =====================POSTS SECTION======================== -->
<?php if (mysqli_num_rows($posts) > 0):?>
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
<?php else : ?> 
    <div class="alert_message error lg">
        <p style="text-align: center;">There's currently no post at this page!</p>
    </div>
<?php endif ?>
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