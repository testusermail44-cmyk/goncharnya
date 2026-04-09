<?php
session_start();
$mainDir = '../';
include('../config/connectDB.php');
include('../models/product.php');
include('../templates/helper.php');
if (!isset($_SESSION['pottery_user']) || $_SESSION['pottery_user']['admin'] != 1) {
    header('Location: ../pages/home.php');
    exit;
}
$categories = getCategories($pdo);
if (isset($_POST['category'])) {
    updateCategory($pdo, $_POST['id'], $_POST['category']);
    header('Location: categories.php');
    exit;
}
if (isset($_POST['new'])){
    newCategory($pdo, $_POST['new']);
    header('Location: categories.php');
    exit;
}
if(isset($_GET['del'])){
    delCategory($pdo, $_GET['del']);
    header('Location: categories.php');
    exit;
}
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
        <?php include('sidepanel.php'); ?>
        <div class="vertical">
        <form class="horizontal admin-p" method="post">
            <?php
            create_input('Додати категорію', 'new', 'new', 'text', '', 'Назва', '', true);
            ?>
            <button class="clay-btn">Додати</button>
        </form>
        <div class="forms-container">
            <?php foreach ($categories as $c) {
                ?>
                <form class="category-panel" method="post">
                    <div class="vertical ct">
                        <div class="light-text">ID: <?= $c->id ?></div>
                        <div class="clay"><?= $c->name ?></div>
                        <div class="horizontal">
                            <button id="show" type="button" onclick="toggleEditor(this)"
                                class="edit-btn">Редагувати</button>
                            <a href="?del=<?= $c->id ?>" class="delete-btn">Видалити</a>
                        </div>
                    </div>
                    <div id="category-editor" class="category-info hide">
                        <input type="hidden" name="id" value="<?= $c->id ?>" />
                        <?php
                        create_input('Назва', 'category', 'category', 'text', '', 'Назва', $c->name, true);
                        ?>
                        <button class="edit-btn">Зберегти</button>
                    </div>
                </form>
                <?php
            }
            ?>
        </div>
        </div>
    </main>
    <script>
        function toggleEditor(btn) {
            const form = btn.closest('.category-panel');
            const editor = form.querySelector('.category-info');
            if (editor.classList.contains('hide')) {
                editor.classList.remove('hide');
                editor.classList.add('show');
                btn.textContent = 'Скасувати';
            } else {
                editor.classList.remove('show');
                editor.classList.add('hide');
                btn.textContent = 'Редагувати';
            }
        }
    </script>
</body>

</html>