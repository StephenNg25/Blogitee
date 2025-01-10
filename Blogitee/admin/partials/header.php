<?php
require '../config/database.php';

if(!isset($_SESSION[ 'user-id'])) {
    header ('location:' . ROOT_URL. 'signin.php');
    die();
}

if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>PHP & MySQL Blog Website</title>
    <!-- STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>style.css?v=<?= time() ?>">
    <!-- ICONSCOUT -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URL ?>" class="nav_logo">BLOGITEE</a>
            <ul class="nav_items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog Search</a></li> <!-- This means href="http://localhost/blogitee/blog.php" -->
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user-id'])) : ?>
                    <li class="nav_profile">
                        <div class="avatar">  
                            <img src="<?= ROOT_URL , 'images/' . $avatar['avatar'] ?>">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <?php endif ?>
            </ul>
            <!-- A menu options for smaller devices -->
            <button id="open_nav_opts"><i class="uil uil-bars"></i></button> 
            <button id="close_nav_opts"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- =====================END OF NAVIGATION BAR======================== -->