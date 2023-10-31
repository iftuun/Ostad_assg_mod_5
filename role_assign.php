<?php
include 'settings.php';
include 'functions.php';
if ($_SESSION['loged_in'] != true) {
    header('Location: login.php');
}
$userData = $_SESSION['user'];
if ($userData['role'] != "admin") {
    header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email=$_POST['user'];
    $userId= findUserKey($email);
    $allUsers = getAllUser($file_path);
    $allUsers[$userId]['role'] = $_POST['role'];
    if(file_put_contents($file_path, json_encode($allUsers))==false){
        echo "Error";
    }
    else{
        echo "Success";
        ?>
<script>
setTimeout(function() {
    window.location.href = "role_management.php";
}, 1000);
</script>
<? } } ?>