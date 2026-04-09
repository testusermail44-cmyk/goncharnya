<?php
session_start();
$mainDir = '../';
?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Доставка</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main class="vertical info-main">
        <div class="info-panel" style="width:100%;">
            <div class="glow"></div>
            <div class="info-label">◆ інформація</div>
            <div class="info-title">Доставка</div>
            <div class="info-text">Відправляємо по всій Україні. Дбайливо пакуємо кожен виріб, щоб він доїхав цілим і
                подарував вам радість.</div>
        </div>
        <div class="info-label">◆ способи доставки</div>
        <h1>Оберіть зручний варіант</h1>
        <div class="post-cards">
            <div class="delivery-big-card">
                <div class="post-cont" style="background:#ee1c25;">
                    <img class="post-img" src="../public/images/post/nova.jpg" />
                    <span class="post-name" style="color:var(--lightText)">Нова пошта</span>
                </div>
                <div class="post-info">
                    <span class="post-price">80 грн</span>
                    <span class="post-time">⏱ 1–3 робочих дні · по всій Україні</span>
                    <div class="post-benefits">
                        <span class="post-benefit">Відділення або поштома</span>
                        <span class="post-benefit">Кур'єр до дверей (+70 грн)</span>
                        <span class="post-benefit">Відстеження посилки онлайн</span>
                        <span class="post-benefit">Оплата при отриманні</span>
                    </div>
                </div>
            </div>
            <div class="delivery-big-card">
                <div class="post-cont" style="background:white;">
                    <img class="post-img" src="../public/images/post/ukrposhta.jpg" />
                    <span class="post-name" style="color:var(--clay)">Укрпошта</span>
                </div>
                <div class="post-info">
                    <span class="post-price">60 грн</span>
                    <span class="post-time">⏱ 1–3 робочих дні · по всій Україні</span>
                    <div class="post-benefits">
                        <span class="post-benefit">Відділення Укрпошти</span>
                        <span class="post-benefit">Кур'єр до дверей (+50 грн)</span>
                        <span class="post-benefit">Відстеження посилки</span>
                        <span class="post-benefit">Доступно у всіх містах</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="free-banner">
            <div class="banner-dots"></div>
            <div class="left-info">
                <div class="left-label">вигідна умова</div>
                <div class="left-title">Безкоштовна доставка</div>
                <div class="left-text">Замовляйте на суму від 1000 грн і отримуйте доставку Новою Поштою безкоштовно.
                    Без жодних умов та прихованих платежів.</div>
            </div>
            <div class="right-info">
                <span class="big-price">1000</span>
                <span class="right-info-text">грн ◆ безкоштовна доставка</span>
            </div>
        </div>
        <div class="info-label">◆ Як це працює</div>
        <h1>Від замовлення до дверей</h1>
        <div class="delivery-container">
            <div class="delivery-circle">🛒</div>
            <div class="delivery-line"></div>
            <div class="delivery-circle">✅</div>
            <div class="delivery-line"></div>
            <div class="delivery-circle">📦</div>
            <div class="delivery-line"></div>
            <div class="delivery-circle">🎉</div>
        </div>
        <div class="delivery-container g">
            <div class="delivery-info-container">
                <div class="delivery-name">Оформлення</div>
                <div class="delivery-text">Обираєте товар, додаєте до кошика і оформлюєте замовлення онлайн</div>
            </div>
            <div class="delivery-info-container">
                <div class="delivery-name">Підтвердження</div>
                <div class="delivery-text">Ми зв'яжемось з вами протягом години і підтвердимо замовлення</div>
            </div>
            <div class="delivery-info-container">
                <div class="delivery-name">Упакування</div>
                <div class="delivery-text">Дбайливо упаковуємо кожен виріб у захисний матеріал і відправляємо</div>
            </div>
            <div class="delivery-info-container">
                <div class="delivery-name">Отримання</div>
                <div class="delivery-text">Отримуєте посилку у відділенні або кур'єром прямо до дверей</div>
            </div>
        </div>
    </main>
    <?php
    include('../templates/footer.php');
    ?>
</body>

</html>