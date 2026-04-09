<?php
session_start();
$mainDir = '../';
?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Оплата</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main class="vertical info-main">
        <div class="info-panel" style="width:100%;">
            <div class="glow"></div>
            <div class="info-label">◆ інформація</div>
            <div class="info-title">Способи оплати</div>
            <div class="info-text">Обирайте зручний спосіб.</div>
        </div>
        <div class="info-label">◆ Способи оплати</div>
        <h1>Оберіть зручний варіант</h1>
        <div class="info-cards">
            <div class="delivery-big-card">
                <div class="info-cont" style="background: linear-gradient(135deg, #3a2810, #6a3818, #b06030);">
                    <div class="payment-logo">📦</div>
                    <span class="info-name" style="color:var(--lightText)">Накладний платіж</span>
                </div>
                <div class="info-info">
                    <span class="info-text-card">Оплачуєте замовлення готівкою або карткою у відділенні Нової Пошти чи Укрпошти при отриманні. </span>
                    <div class="info-benefits">
                        <span class="info-benefit">Оплата після отримання та огляду</span>
                        <span class="info-benefit">Готівка або термінал у відділенні</span>
                        <span class="info-benefit">Можна відмовитись від пошкодженого товару</span>
                    </div>
                </div>
            </div>
            <div class="delivery-big-card">
                <div class="info-cont" style="background: linear-gradient(135deg, #1a1a3a, #303080, #5050c0);">
                    <div class="payment-logo">🏦</div>
                    <span class="info-name" style="color:var(--lightText)">Банківський переказ</span>
                </div>
                <div class="info-info">
                    <span class="info-text-card">Переказ на рахунок ФОП для юридичних осіб. Надаємо рахунок-фактуру та всі необхідні документи.</span>
                    <div class="info-benefits">
                        <span class="info-benefit">Безготівковий розрахунок</span>
                        <span class="info-benefit">Рахунок-фактура та акт</span>
                        <span class="info-benefit">Відправка після зарахування</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="info-label">◆ Повернення коштів</div>
        <h1>Прозора політика</h1>
        <div class="pay-info-container">
            <div class="pay-info">
                <div class="pay-title">14</div>
                <div class="pay-small-text">Днів на повернення</div>
                <div class="pay-name">Стандартне повернення</div>
                <div class="pay-text">14 днів після отримання щоб повернути товар у незміненому стані без пояснення причин.</div>
            </div>
            <div class="pay-info">
                <div class="pay-title">3</div>
                <div class="pay-small-text">Робочих дні</div>
                <div class="pay-name">Повернення коштів</div>
                <div class="pay-text">Після підтвердження повернення гроші надходять на картку або рахунок протягом 3 робочих днів.</div>
            </div>
            <div class="pay-info">
                <div class="pay-title">100%</div>
                <div class="pay-small-text">Сума повернення</div>
                <div class="pay-name">Пошкоджений товар</div>
                <div class="pay-text">Якщо товар прийшов пошкодженим — повертаємо повну суму з доставкою без зайвих питань.</div>
            </div>
        </div>
    </main>
    <?php
    include('../templates/footer.php');
    ?>
</body>

</html>