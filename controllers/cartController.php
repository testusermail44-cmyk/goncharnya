<?php
session_start();
include('../config/connectDB.php');
include('../models/product.php');
include('../templates/helper.php');
$mainDir = '../';
if (!isset($_SESSION['pottery_user']['id'])) {
    header('Location: ../auth/login.php');
    exit;
}
$ids = array_column($_SESSION['cart'], 'product');
$products = [];
if (!empty($_SESSION['cart'])) {
    $products = getProductsForCart($pdo, $ids);
}
if (isset($_GET['del'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product'] == $_GET['del']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
    header("Location: cart.php");
    exit();
}
?>