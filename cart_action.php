<?php
session_start();
include "koneksi.php";

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if (isset($_SESSION['cart'][$id])) {
        if ($action == 'increase') {
            $_SESSION['cart'][$id]++;
        } elseif ($action == 'decrease') {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
    header("Location: cart.php");
    exit;
} else {
    header("Location: cart.php");
    exit;
}
?>