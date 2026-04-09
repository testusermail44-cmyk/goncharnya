<?php
session_start();
$mainDir = '../';
if (!isset($_SESSION['pottery_user']['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Успіх</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main>
        <div class="success">
            <div class="success-circle"></div>
            <div class="light-text" style="color:var(--clay);font-size:30px;">Замовлення прийнято</div>
            <div class="light-text" style="font-size:20px;">Ваше замовлення
                <?= '#' . str_pad($_GET['id'], 4, '0', STR_PAD_LEFT) ?> успішно оформлено. Ми зв'яжемось з вами протягом
                години для підтвердження.</div>
        </div>
    </main>
    <?php
    include('../templates/footer.php');
    ?>
</body>

</html>