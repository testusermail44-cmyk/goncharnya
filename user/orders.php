<?php
session_start();
$mainDir = '../';
require_once '../controllers/ordersController.php';
$resPrice = 0;
if (!isset($_SESSION['pottery_user']['id'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>
<html lang="uk">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Кошик</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main class="orders-main">
        <div class="info-panel order">
            <div class="glow"></div>
            <div class="info-title">Замовлення</div>
        </div>
        <div class="user-orders-container">
            <?php
            if (count($orders) == 0) {
                ?>
                <div class="vertical center c">
                    <div class="empty-order-text">У вас ще немає замовлень!</div>
                </div>
                <?php
            } else {
                foreach ($orders as $o) {
                    ?>
                    <div class="user-order-container">
                        <div class="user-order-info">
                            <div class="light-text">#<?= str_pad($o->id, 4, '0', STR_PAD_LEFT) ?></div>
                            <div class="light-text"><?= $o->date ?></div>
                            <div class="light-text">Доставка: <?= $o->delivery == 1 ? 'Нова пошта' : 'Укрпошта' ?></div>
                            <div class="light-text">Статус:
                                <?= $o->status == 0 ? 'в обробці' : ($o->status == 1 ? 'відправлено' : 'завершено') ?>
                            </div>
                        </div>
                        <div class="user-order-info i">
                            <div class="user-order-items">
                                <?php
                                foreach ($itemsByOrders[$o->id] as $i) {
                                    ?>
                                    <div class="user-order-item-image-container">
                                        <img class="user-order-image" src="<?= (strpos($i->image, 'http') === 0)
                                            ? $i->image
                                            : "../public/images/pottery/" . $i->image ?>"
                                            onerror="this.onerror=null; this.src='../public/images/pottery/default.png';" />
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="price"><?= $o->price ?> грн</div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </main>
    <?php
    include('../templates/footer.php');
    ?>
</body>

</html>