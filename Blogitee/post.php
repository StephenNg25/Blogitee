<?php
include 'partials/header.php';

// Fetch post from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); // Sanitize the input to ensure it's a valid integer
    $query = "SELECT * FROM posts WHERE id=$id"; // Query to fetch the post with the specified id
    $result = mysqli_query($connection, $query); // Execute the query
    $post = mysqli_fetch_assoc($result); // Fetch the result as an associative array
} else {
    // If id is not set, redirect to the blog page
    header('Location: ' . ROOT_URL . 'blog.php');
    die(); // Terminate script execution
}

?>

    <!-- =====================SELECTED POST======================== -->
    <section class="selectedpost">
        <div class="container selectedpost_container">
            <h2><?= $post['title'] ?></h2>
            <?php
                    // Fetch author from users table using author_id
                    $author_id = $post['author_id']; // Retrieve the author_id from the post data
                    $author_query = "SELECT * FROM users WHERE id=$author_id"; // Query to fetch the author details from the users table
                    $author_result = mysqli_query($connection, $author_query); // Execute the query
                    $author = mysqli_fetch_assoc($author_result); // Fetch the result as an associative array
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
            <div class="selectedpost_thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>" >
            </div>
            <p>
                <?= nl2br($post['body']) ?> <!-- Allow existed line break from textarea of edit/add post! -->
            </p>
        </div>
    </section>
    
    <!-- =====================END OF SELECTED POST======================== -->

<?php
include 'partials/footer.php';
?>
    