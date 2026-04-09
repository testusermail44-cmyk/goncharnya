<?php
session_start();
include('../config/connectDB.php');
include('../models/product.php');
include('../models/order.php');
include('../templates/helper.php');
$mainDir = '../';
if (!isset($_SESSION['pottery_user']['id'])) {
    header('Location: ../auth/login.php');
    exit;
}
if (empty($_SESSION['cart'])) {
    header('Location: ../pages/home.php');
    exit;
}

$ids = array_column($_SESSION['cart'], 'product');
$products = getProductsForCart($pdo, $ids);
$productsAmountByCart = [];
foreach ($products as $p) {
    $productsAmountByCart[$p->id][] = $p->amount;
}
if (isset($_POST['name'])) {
    $id = createOrder($pdo, $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['price'], $_POST['delivery'], $_POST['payment'], $_POST['city'], $_POST['department'], $_POST['phone'], $_SESSION['pottery_user']['id']);
    createOrderItems($pdo, $id, $_SESSION['cart']);
    removeFromStorage($pdo, $_SESSION['cart'], $productsAmountByCart);
    $_SESSION['cart'] = [];
    Header('Location: success.php?id=' . $id);
    exit();
}
?>