<?php
require_once '../controllers/CatalogController.php';
?>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Каталог</title>
</head>
<body>
    <?php include('../templates/header.php'); ?>
    <main>
        <form class="filter" method="get">
            <span class="filter-text">ЦІНА</span>
            <div class="slider-container">
                <input type="range" min="0" max="<?=$maxPrice?>" name="price" value="<?=isset($_GET['price']) ? $_GET['price'] : $maxPrice?>" />
                <div class="price-container">
                    <div class="light-text">0</div>
                    <div class="light-text"><?=$maxPrice?></div>
                </div>
            </div>
            <span class="filter-text">КАТЕГОРІЇ</span>
            <div class="checkboxes">
                <?php
                    foreach($categories as $c) {
                        $checked = isset($_GET['category']) && in_array($c->id, (array)$_GET['category']);
                        custom_checkbox('category[]', $c->id, $c->name, $checked);
                    }
                ?>
            </div>
            <span class="filter-text">КОЛІР ГЛИНИ</span>
            <div class="checkboxes">
                <?php
                    foreach($colors as $c) {
                        $checked = isset($_GET['color']) && in_array($c->id, (array)$_GET['color']);
                        custom_checkbox('color[]', $c->id, $c->name, $checked);
                    }
                ?>
            </div>
            <span class="filter-text">СТИЛЬ</span>
            <div class="checkboxes">
                <?php
                    foreach($styles as $s) {
                        $checked = isset($_GET['style']) && in_array($s->id, (array)$_GET['style']);
                        custom_checkbox('style[]', $s->id, $s->name, $checked);
                    }
                ?>
            </div>
            <button class="clay-btn">Застосувати</button>
        </form>
        <div class="vertical full">
            <form method="get" class="search-container">
                <input class="search-input" name="search" />
                <button class="search-btn">🔍</button>
            </form>
            <div class="card-container">
                <?php
                if (count($products) == 0) {
                    ?>
                    <div class="no-result">За вашим запитом нічого не знайдено!</div>
                    <?php
                }
                foreach ($products as $p) {
                    product_card($p->id, $p->image, $p->product, $p->category, $p->price);
                }
                ?>
            </div>
            <div class="pages">
                <?=createPages($productCount->count, $_GET['page']??1)?>
            </div>
        </div>
    </main>
    <?php include('../templates/footer.php'); ?>
</body>

</html>