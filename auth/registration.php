<?php
    require_once '../controllers/registrationController.php';
?>
<html lang="uk">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../public/css/style.css" />
        <title>Реєстрація</title>
    </head>
<body>
    <?php
    include('../templates/header.php');
    ?>
    <main class="auth-main">
        <div class="auth-left">
            <div class="left-cont">
                <div class="auth-title">Станьте частиною нашої спільноти</div>
                <div class="auth-text">Реєстрація відкриває вам доступ до світу українського гончарства, де кожна річ має душу.</div>
                <div class="info-label light" style="margin-top: 50px;">◆ Зручний доступ</div>
                <div class="auth-text margin">Переглядайте історію замовлень та керуйте вмістом кошика в особистому кабінеті.</div>
                <div class="info-label light">◆ Розвиток традицій</div>
                <div class="auth-text margin">Підтримуйте ремесло, стаючи частиною нашого шляху у збереженні культури.</div>
            </div>
        </div>
        <div class="auth-right">
            <div class="info-label">◆ Реєстрація</div>
            <h1>Новий акаунт</h1>
            <div class="light-text">Вже маєте акаунт?
                <a class="link" href="login.php">Увійти</a>
            </div>
            <form class="auth-form" method="post">
                <div class="horizontal">
                    <?= create_input('Ім\'я', 'name', 'name', 'text', '👤', 'Ваше ім\'я', $name, true) ?>
                    <?= create_input('Прізвище', 'surname', 'surname', 'text', '👤', 'Ваше прізвище', $surname, true) ?>
                </div>
                <?= create_input('Email', 'email', 'email', 'email', '✉️', 'example@gmail.com', $email, true) ?>
                <?= create_input('Пароль', 'password', 'pass', 'password', '🔒', 'Мінімум 6 символів', $password, true) ?>
                <?= create_input('Повторити пароль', 'confirm', 'confirm', 'password', '🔒', 'Повторіть пароль', $confirm, true) ?>
                <button class="clay-btn" type="submit">Зареєструватись</button>
                <?php if ($error): ?>
                    <div class="error"><?=$error?></div>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>
</html>