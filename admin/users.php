<?php
session_start();
include('../config/connectDB.php');
include('../models/user.php');
$mainDir = '../';
if (!isset($_SESSION['pottery_user']) || $_SESSION['pottery_user']['admin'] != 1) {
    header('Location: ../pages/home.php');
    exit;
}
$users = getUsers($pdo);
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
        <div class="center-panel">
            <div class="users-table">
                <div class="users-table-info">
                    <div class="light-text t-item">Користувач</div>
                    <div class="light-text  t-item">Email</div>
                    <div class="light-text  t-item">Роль</div>
                </div>
                <?php
                foreach ($users as $u) {
                    ?>
                    <div class="users-table-container">
                        <div class="horizontal  t-item">
                            <img class="user-table-img" src="<?= (strpos($u->image, 'http') === 0)
                                ? $u->image
                                : "../public/images/users/" . $u->image ?>" />
                            <div class="dark"><?= $u->name . ' ' . $u->surname ?></div>
                        </div>
                        <div class="dark  t-item"><?= $u->email ?></div>
                        <div class="dark  t-item"><?= $u->admin == 1 ? 'Адміністратор' : 'Користувач' ?></div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>