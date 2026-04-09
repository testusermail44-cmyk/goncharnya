<?php
function createOrder($pdo, $name, $surname, $email, $price, $delivery, $payment, $city, $department, $phone, $userId)
{
    $stmt = $pdo->prepare("INSERT INTO orders(name, surname, email, price, delivery, payment, city, department, phone, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $surname, $email, $price, $delivery, $payment, $city, $department, $phone, $userId]);
    return $pdo->lastInsertId();
}

function createOrderItems($pdo, $order, $products)
{
    if (empty($products))
        return;
    $values = [];
    $placeholders = [];
    foreach ($products as $item) {
        $placeholders[] = "(?, ?, ?)";
        $values[] = $order;
        $values[] = $item['product'];
        $values[] = $item['count'];
    }
    $sql = "INSERT INTO order_items (order_id, product, count) VALUES ".implode(', ', $placeholders);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
}

function getOrders($pdo, $userId){
    $stmt = $pdo->prepare('SELECT o.id, o.price, o.date, o.status, o.delivery FROM orders as o WHERE o.user_id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getItems($pdo, $orders){
    $placeholders = str_repeat('?,', count($orders) - 1) . '?';
    $stmt = $pdo->prepare("SELECT o.order_id,  o.count, p.name, p.price, p.image FROM order_items as o, products as p WHERE o.product = p.id AND o.order_id IN ($placeholders)");
    $stmt->execute($orders);
    return $stmt->fetchAll();
}

function getAllOrders($pdo){
    $stmt = $pdo->prepare('SELECT o.id, o.name, o.surname, o.price, o.date, o.status, o.delivery FROM orders as o ORDER BY o.status DESC');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getOrderInfo($pdo, $id){
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getOrderItems($pdo, $id){
    $stmt = $pdo->prepare("SELECT o.count, p.name, p.id, p.price, p.image FROM order_items as o, products as p WHERE o.order_id = ? AND p.id = o.product");
    $stmt->execute([$id]);
    return $stmt->fetchAll();
}

function setStatus($pdo, $status, $id){
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}
?>