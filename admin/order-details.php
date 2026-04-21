<?php
session_start();
$mainDir = '../';
include('../config/connectDB.php');
include('../models/order.php');
if (!isset($_SESSION['pottery_user']) || $_SESSION['pottery_user']['admin'] != 1) {
    header('Location: ../pages/home.php');
    exit;
}
$id = $_GET['id'];
$order = getOrderInfo($pdo, $id);
$items = getOrderItems($pdo, $id);
if (isset($_POST['status'])) {
    setStatus($pdo, $_POST['status'], $id);
    Header("Location: order-details.php?id=" . $id);
    exit();
}
?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <link rel="stylesheet" href="../public/css/admin.css" />
    <title>Адмін-панель</title>
</head>

<body>
    <?php include('../templates/header.php'); ?>
    <main class="admin-panel">
        <?php include('sidepanel.php') ?>
        <form class="panel" method="post">
            <div class="oip">
                <div class="user-orders-info-container">
                    <div class="user-order-info-container">
                        <div class="light-text">КЛІЄНТ</div>
                        <div class="dark"><?= $order->name . ' ' . $order->surname ?></div>
                        <div class="light-text"><?= $order->email ?></div>
                        <div class="light-text"><?= $order->phone ?></div>
                    </div>
                    <div class="user-order-info-container">
                        <div class="light-text">ДОСТАВКА</div>
                        <div class="dark"><?= $order->delivery == 1 ? 'Нова пошта' : 'Укрпошта' ?></div>
                        <div class="dark"><?= $order->department ?></div>
                        <div class="light-text"><?= $order->city ?></div>
                    </div>
                    <div class="user-order-info-container">
                        <div class="light-text">ОПЛАТА</div>
                        <div class="dark"><?= $order->payment == 1 ? 'Накладний платіж' : 'Переказ на рахунок' ?></div>
                    </div>
                </div>
                <div class="light-text">ТОВАРИ</div>
                <div class="products-box-container">
                    <?php
                    foreach ($items as $item) {
                        ?>
                        <div class="product-box">
                            <div class="horizontal">
                                <img class="product-box-img" src="<?= (strpos($item->image, 'http') === 0)
                                    ? $item->image
                                    : "../public/images/pottery/" . $item->image ?>"
                                    onerror="this.onerror=null; this.src='../public/images/pottery/default.png';" />
                                <div class="vertical">
                                    <div class="light-text">ID: <?= $item->id ?></div>
                                    <div class="dark"><?= $item->name . ' ' . $item->count . ' шт' ?></div>
                                </div>
                            </div>
                            <div class="clay"><?= $item->price ?></div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="horizontal big center">
                    <div class="dark big">До сплати</div>
                    <div class="clay big" style="font-size:18px;"><?= $order->price ?> грн</div>
                </div>
                <div class="custom-select">
                    <select name="status">
                        <option value="0" <?= $order->status == 0 ? 'selected' : '' ?>>В обробці</option>
                        <option value="1" <?= $order->status == 1 ? 'selected' : '' ?>>Відправлено</option>
                        <option value="2" <?= $order->status == 2 ? 'selected' : '' ?>>Завершено</option>
                    </select>
                </div>
                <button class="clay-btn">Зберегти</button>
            </div>
        </form>
    </main>
</body>

</html>