<?php
require_once '../controllers/loginController.php';
?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Авторизація</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main class="auth-main">
        <div class="auth-left">
            <div class="left-cont">
                <div class="auth-title">Ласкаво<br>просимо</div>
                <div class="auth-text">Увійдіть, щоб переглянути свої замовлення, кошик та улюблені вироби майстрів.</div>
                <div class="info-label light" style="margin-top: 50px;">◆ Ваш світ кераміки</div>
                <div class="auth-text margin">Відкрийте для себе тисячі унікальних робіт.</div>
                <div class="info-label light">◆ Підтримка майстрів</div>
                <div class="auth-text margin">Кожна покупка допомагає розвивати ремесло.</div>
            </div>
        </div>
        <div class="auth-right">
            <div class="info-label">◆ Авторизація</div>
            <h1>Вхід до акаунту</h1>
            <div class="light-text">Ще не маєте акаунту?
                <a class="link" href="registration.php">Зареєструватись</a>
            </div>
            <form class="auth-form" method="post">
                <?= create_input('Email', 'email', 'email', 'email', '✉️', 'example@gmail.com', $email, true) ?>
                <?= create_input('Пароль', 'password', 'pass', 'password', '🔒', 'Ваш пароль', $password, true) ?>
                <?= custom_checkbox('remember', '1', "Запам'ятати мене", $remember) ?>
                <button class="clay-btn" type="submit">Увійти</button>
                <?php if ($error): ?>
                    <div class="error"><?=$error?></div>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>

</html>