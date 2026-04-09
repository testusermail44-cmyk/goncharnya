<?php
$mainDir = '../';
session_start();
?>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Про нас</title>
</head>
<body>
    <?php include('../templates/header.php'); ?>
    <main class="vertical info-main">
        <div class="info-panel" style="width:100%;">
            <div class="glow"></div>
            <div class="info-label">◆ наша історія</div>
            <div class="info-title">Про глину, тепло та душу</div>
            <div class="info-text">Ми створюємо кераміку, яка зберігає тепло рук майстра та приносить затишок у кожну оселю. Кожен виріб — це маленька історія, яку ми пишемо разом з вами.</div>
        </div>
        <div style="display: flex; gap: 40px; margin: 60px 0;">
            <div style="flex: 1;">
                <div class="info-label">◆ заснування</div>
                <h1 style="margin-top: 0;">Від хобі до улюбленої справи</h1>
                <div class="info-text" style="color: var(--light); margin-bottom: 20px;">
                    Все почалося з невеликої майстерні. Ми захопилися керамікою і вирішили ділитися своєю любов'ю до глини з іншими.
                </div>
                <div class="info-text" style="color: var(--light);">
                    Сьогодні наша команда — це майстри, які поєднують традиційні техніки з сучасним дизайном. Ми віримо, що навіть проста чашка може дарувати натхнення щодня.
                </div>
            </div>
             
        </div>
        <div class="info-label">◆ наші цінності</div>
        <h1>Те, у що ми віримо</h1>
        <div class="post-cards" style="margin-bottom: 60px;">
            <div class="delivery-big-card" style="max-width: 100%; flex: 1;">
                <div class="post-cont" style="background: var(--clay); padding: 30px 0; text-align: center;">
                    <div style="font-size: 48px;">✨</div>
                    <span class="post-name" style="color:var(--lightText); font-size: 24px;">Унікальність</span>
                </div>
                <div class="post-info">
                    <span class="post-time">Кожен виріб існує в єдиному екземплярі. Ми не робимо конвеєрних виробів.</span>
                </div>
            </div>
            <div class="delivery-big-card" style="max-width: 100%; flex: 1;">
                <div class="post-cont" style="background: var(--dark); padding: 30px 0; text-align: center;">
                    <div style="font-size: 48px;">🤝</div>
                    <span class="post-name" style="color:var(--lightText); font-size: 24px;">Щирість</span>
                </div>
                <div class="post-info">
                    <span class="post-time">Ми відкриті до діалогу та завжди раді допомогти з вибором.</span>
                </div>
            </div>
            <div class="delivery-big-card" style="max-width: 100%; flex: 1;">
                <div class="post-cont" style="background: var(--clay-dark); padding: 30px 0; text-align: center;">
                    <div style="font-size: 48px;">🌍</div>
                    <span class="post-name" style="color:var(--lightText); font-size: 24px;">Українське</span>
                </div>
                <div class="post-info">
                    <span class="post-time">Підтримуємо локальне виробництво та використовуємо українську глину.</span>
                </div>
            </div>
        </div>
        <div class="free-banner" style="margin-bottom: 60px;">
            <div class="banner-dots"></div>
            <div class="left-info">
                <div class="left-label">запрошуємо до знайомства</div>
                <div class="left-title">Підтримуйте українське</div>
                <div class="left-text">Обирайте кераміку ручної роботи, яка зігріває душу.</div>
            </div>
        </div>
    </main>
    <?php include('../templates/footer.php'); ?>
</body>
</html>