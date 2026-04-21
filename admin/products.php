<?php
session_start();
$mainDir = '../';
include('../config/connectDB.php');
include('../models/product.php');
if (!isset($_SESSION['pottery_user']) || $_SESSION['pottery_user']['admin'] != 1) {
    header('Location: ../pages/home.php');
    exit;
}
$products = getProducts($pdo, 0, null);
if (isset($_GET['del'])) {
    deleteProduct($pdo, $_GET['del']);
    header('Location: products.php');
    exit;
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
        <div class="con">
            <a class="clay-btn" href="productEditor.php">Додати продукт</a>
            <div class="p-a-c">
                <?php
                foreach ($products as $p) {
                    ?>
                    <div class="product-a-c">
                        <img class="product-a-c-i" src="<?= (strpos($p->image, 'http') === 0)
                            ? $p->image
                            : "../public/images/pottery/" . $p->image ?>"
                            onerror="this.onerror=null; this.src='../public/images/pottery/default.png';" />
                        <div class="dark btg"><?= $p->product ?></div>
                        <div class="horizontal">
                            <a href='productEditor.php?edit=<?= $p->id ?>' class="clay-btn">Редагувати</a>
                            <a href="?del=<?= $p->id ?>" class="delete">Видалити</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>