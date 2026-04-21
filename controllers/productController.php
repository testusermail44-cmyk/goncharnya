<?php
session_start();
include('../config/connectDB.php');
include('../models/product.php');
include('../models/review.php');
$mainDir = '../';
$id = $_GET['id'];
$product = getProduct($pdo, $id);
addView($pdo, $id, $product->views);
$reviews = getReviews($pdo, $id);
if (isset($_GET['del'])) {
    deleteReview($pdo, $_GET['del']);
    header('Location: product.php?id='.$id);
    exit();
}
if (isset($_POST['review'])) {
    addReview($pdo, $_SESSION['pottery_user']['id'], $id, $_POST['review'], $_POST['rating']);
    header('Location: product.php?id='.$id);
    exit();
}
if (isset($_POST['product'])) {
    if (!isset($_SESSION['pottery_user']['id'])) {
        header('Location: ../auth/login.php');
        exit();
    }
    $cartProduct = ['product' => $_POST['product'], 'count' => $_POST['counter']];
    if (isset($_SESSION['cart'])) {
        $has = false;
        foreach($_SESSION['cart'] as &$c) {
            if ($c['product'] == $_POST['product']){
                if ($c['count'] + $_POST['counter'] > $product->amount)
                    $c['count'] = $product->amount;
                else
                    $c['count'] += $_POST['counter'];
                $has = true;
                break;
            }
        }    
        if (!$has) 
            $_SESSION['cart'][] = $cartProduct;
    }
    else
        $_SESSION['cart'] = [$cartProduct]; 
    header('Location: product.php?id='.$id);
    exit();
}
 
?>