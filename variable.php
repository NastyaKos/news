<?php
session_start();

$_SESSION['news_per_page'] = $_POST['news_per_page'];
$_SESSION['sort'] = $_POST['sort'];
$_SESSION['category'] = $_POST['category'];

header('Location: /');