<?php
session_start();
$mainDir = '../';
?>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Гончарня — кераміка ручної роботи</title>
</head>
<body>
    <?php include('../templates/header.php'); ?>
    
    <main class="vertical info-main">
        <div class="main-section">
            <div class="main-content">
                <div class="main-label">◆ ручна робота</div>
                <div class="main-title">Кераміка з душею</div>
                <div class="main-text">Кожен виріб народжується в руках майстра. Унікальні форми, натуральна глина та тепло, яке зберігається роками.</div>
                <a href="catalog.php" class="clay-btn main-btn">До каталогу</a>
            </div>
            <div class="main-decoration">
                <div class="main-circle">🏺</div>
            </div>
        </div>
        <div class="info-label">◆ чому обирають нас</div>
        <h1>Наші переваги</h1>
        
        <div class="advantages-grid">
            <div class="advantage-card">
                <div class="advantage-icon">🤲</div>
                <div class="advantage-title">Ручна робота</div>
                <div class="advantage-text">Кожен виріб унікальний та створений вручну</div>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">🌿</div>
                <div class="advantage-title">Натуральна глина</div>
                <div class="advantage-text">Екологічно чисті матеріали</div>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">🎁</div>
                <div class="advantage-title">Подарункова упаковка</div>
                <div class="advantage-text">Дбайливо пакуємо кожне замовлення</div>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">🚚</div>
                <div class="advantage-title">Доставка по Україні</div>
                <div class="advantage-text">Новою поштою та Укрпоштою</div>
            </div>
        </div>
        <div class="info-label">◆ категорії</div>
        <h1>Що ми створюємо</h1>
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-icon">🍵</div>
                <div class="category-name">Посуд</div>
                <div class="category-desc">Чашки, тарілки</div>
            </div>
            <div class="category-card">
                <div class="category-icon">🏺</div>
                <div class="category-name">Декор</div>
                <div class="category-desc">Вази, глечики</div>
            </div>
            <div class="category-card">
                <div class="category-icon">🎨</div>
                <div class="category-name">Авторське</div>
                <div class="category-desc">Унікальні вироби в єдиному екземплярі</div>
            </div>
        </div>
    </main>

    <?php include('../templates/footer.php'); ?>
</body>
</html>