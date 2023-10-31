<?php
include 'settings.php';
if ($_SESSION['loged_in'] != true) {
    header('Location: login.php');
}
$userData = $_SESSION['user'];
if ($userData['role'] === "admin") {
    include 'admin-index.php';
} elseif ($userData['role'] === "modarator") {
    include 'modarator-index.php';
} elseif ($userData['role'] === "editor") {
    include 'editor-index.php';
} elseif ($userData['role'] === "author") {
    include 'author-index.php';
}else{
    echo 'You have no role';
    exit();
}
?>