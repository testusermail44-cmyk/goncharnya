<?php
include('../config/connectDB.php');
include('../models/order.php');
$orders = getOrders($pdo, $_SESSION['pottery_user']['id']);
$ids = array_column($orders, 'id');
$items = [];
if (count($orders)> 0)
    $items = getItems($pdo, $ids);
$itemsByOrders = [];
foreach ($items as $item) {
    $itemsByOrders[$item->order_id][] = $item;
}
?>

