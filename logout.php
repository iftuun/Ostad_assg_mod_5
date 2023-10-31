<?php
include 'settings.php';
session_destroy();
header('Location: login.php');
?>