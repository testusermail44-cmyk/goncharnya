<?php
session_start();
$mainDir = '../';
include('../config/connectDB.php');
include('../models/order.php');
if (!isset($_SESSION['pottery_user']) || $_SESSION['pottery_user']['admin'] != 1) {
    header('Location: ../pages/home.php');
    exit;
}
$orders = getAllOrders($pdo);
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
        <div class="order-table">
            <div class="table-row">
                <div class="table-item">#</div>
                <div class="table-item">Клієнт</div>
                <div class="table-item">Сума</div>
                <div class="table-item">Доставка</div>
                <div class="table-item">Статус</div>
                <div class="table-item">Дата</div>
            </div>
            <?php
                foreach($orders as $o){
                    ?>
                    <a href="order-details.php?id=<?=$o->id?>" class="table-row item">
                        <div class="table-item dark">#<?=str_pad($o->id, 4, '0', STR_PAD_LEFT)?></div>
                        <div class="table-item dark"><?=$o->name.' '.$o->surname?></div>
                        <div class="table-item dark"><?=$o->price?></div>
                        <div class="table-item dark"><?=$o->delivery == 1 ? 'Нова пошта' : 'Укрпошта' ?></div>
                        <div class="table-item dark"><?=$o->status == 0 ? 'в обробці' : ($o->status == 1 ? 'відправлено' : 'завершено') ?></div>
                        <div class="table-item dark"><?=$o->date?></div>
                    </a>
                    <?php
                }
            ?>
        </div>
    </main>
</body>

</html>