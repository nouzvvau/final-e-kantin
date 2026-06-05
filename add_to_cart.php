<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    header("Location: homepage.php");
    exit;
} else {
    header("Location: homepage.php");
    exit;
}
?>