<?php
session_start();
$mainDir = '../';
?>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Контакти</title>
</head>
<body>
    <?php include('../templates/header.php'); ?>
    
    <main class="vertical info-main">
        <div class="info-panel">
            <div class="glow"></div>
            <div class="info-label">◆ зв'язок з нами</div>
            <div class="info-title">Контакти</div>
            <div class="info-text">Ми завжди на зв'язку. Пишіть, дзвоніть, заходьте в гості — будемо раді допомогти з вибором або відповісти на запитання.</div>
        </div>
        <div class="contacts-grid">
            <div class="contacts-card">
                <div class="contacts-icon">📞</div>
                <div class="contacts-label">Телефон</div>
                <div class="contacts-value">+38 (099) 123 45 67</div>
                <div class="contacts-small">Пн–Пт: 10:00 – 18:00</div>
            </div>
            <div class="contacts-card">
                <div class="contacts-icon">✉️</div>
                <div class="contacts-label">Email</div>
                <div class="contacts-value">info@goncharnya.ua</div>
                <div class="contacts-small">Відповідаємо протягом дня</div>
            </div>
            <div class="contacts-card">
                <div class="contacts-icon">📷</div>
                <div class="contacts-label">Instagram</div>
                <div class="contacts-value">@goncharnya.ua</div>
                <div class="contacts-small">Акції, новинки, майстер-класи</div>
            </div>
        </div>
    </main>

    <?php include('../templates/footer.php'); ?>
</body>
</html>