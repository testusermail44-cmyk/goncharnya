<?php
session_start();
include('../config/connectDB.php');
include('../models/product.php');
include('../templates/helper.php');
$mainDir = '../';
$products = '';
if (isset($_GET['search'])) {
    $products = searchProduct($pdo, $_GET['search'], $_GET['page'] ?? 1, 9);
    $productCount = getSearchCount($pdo, $_GET['search']);
} else if (isset($_GET['price'])) {
    $result = filter($pdo, $_GET['price'], $_GET['category']??'', $_GET['color']??'', $_GET['style']??'', $_GET['page'] ?? 1, 9);
    $products = $result['products'];
    $productCount = $result['count'];
} else {
    $products = getProducts($pdo, $_GET['page'] ?? 1, 9);
    $productCount = getAllProductsCount($pdo);
}
$categories = getCategories($pdo);
$colors = getColors($pdo);
$styles = getStyles($pdo);
$maxPrice = getMaxPrice($pdo);
?>