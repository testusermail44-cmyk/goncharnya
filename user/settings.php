<?php
session_start();
$mainDir = '../';
if (!isset($_SESSION['pottery_user']['id'])) {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../config/connectDB.php';
require_once '../models/user.php';

$userId = $_SESSION['pottery_user']['id'];
$message = '';
$error = '';

$user = getUserById($pdo, $userId);

if (!$user) {
    session_destroy();
    header('Location: ../auth/login.php');
    exit;
}

if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);

    if (empty($name) || empty($surname)) {
        $error = 'Будь ласка, заповніть всі поля';
    } else {
        if (updateUserProfile($pdo, $userId, $name, $surname)) {
            $message = "Ім'я та прізвище успішно оновлено";
            header('Location: settings.php');
            exit;
        } else {
            $error = 'Помилка при оновленні даних';
        }
    }
}

if (isset($_POST['update_password'])) {
    $result = updateUserPassword(
        $pdo,
        $userId,
        $_POST['current_password'],
        $_POST['new_password'],
        $_POST['confirm_password']
    );

    if ($result['success']) {
        header('Location: settings.php');
        exit;
    } else {
        $error = $result['message'];
    }
}
if (isset($_POST['update_avatar'])) {
    $result = updateUserAvatar($pdo, $userId, $_FILES['avatar'], $user->image);

    if ($result['success']) {
        $message = $result['message'];
        if (isset($result['image'])) {
            $_SESSION['pottery_user']['image'] = $result['image'];
            header('Location: settings.php');
            exit;
        }
    } else {
        $error = $result['message'];
    }
}
if (isset($_POST['delete_avatar'])) {
    $result = deleteUserAvatar($pdo, $userId, $user->image);

    if ($result['success']) {
        header('Location: settings.php');
        exit;
    } else {
        $error = $result['message'];
    }
}
?>
<html lang="uk">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Налаштування профілю</title>
</head>

<body>
    <?php include('../templates/header.php'); ?>
    <main class="vertical" style="min-height: calc(100vh - 61px - 183px);">
        <div class="settings-container">
            <div class="info-label" style="margin-bottom: 10px;">◆ особистий кабінет</div>
            <h1 style="margin-bottom: 30px;">Налаштування профілю</h1>
            <?php if ($message): ?>
                <div class="message success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="message error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="settings-card">
                <div class="settings-title">Фото профілю</div>
                <div class="avatar-section">
                    <div class="avatar-preview">
                        <?php if ($user->image && file_exists('../public/images/users/' . $user->image)): ?>
                            <img src="../public/images/users/<?= htmlspecialchars($user->image) ?>" alt="Avatar">
                        <?php else: ?>
                            <div class="no-avatar">👤</div>
                        <?php endif; ?>
                    </div>
                    <div class="avatar-actions">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="file-input-wrapper">
                                <button type="button" class="clay-btn"
                                    onclick="document.getElementById('avatar-input').click()">
                                    Завантажити фото
                                </button>
                                <input type="file" name="avatar" id="avatar-input" accept="image/*"
                                    style="display: none;" onchange="this.form.submit()">
                            </div>
                            <input type="hidden" name="update_avatar" value="1">
                        </form>
                        <?php if ($user->image && $user->image != 'user.png'): ?>
                            <form method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити фото?')">
                                <button type="submit" name="delete_avatar" class="btn-dark btn-danger">Видалити</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="settings-card">
                <div class="settings-title">Особисті дані</div>
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Ім'я *</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Прізвище *</label>
                        <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($user->surname) ?>"
                            required>
                    </div>

                    <div class="settings-actions">
                        <button type="submit" name="update_profile" class="clay-btn">Зберегти зміни</button>
                    </div>
                </form>
            </div>
            <div class="settings-card">
                <div class="settings-title">Зміна пароля</div>

                <form method="POST">
                    <div class="form-group">
                        <label for="current_password">Поточний пароль *</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Новий пароль *</label>
                        <input type="password" id="new_password" name="new_password" required minlength="6">
                        <div class="small-text" style="margin-top: 5px;">Мінімум 6 символів</div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Підтвердження пароля *</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <div class="settings-actions">
                        <button type="submit" name="update_password" class="clay-btn">Змінити пароль</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include('../templates/footer.php'); ?>

    <script>
        setTimeout(function () {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function (msg) {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(function () {
                    msg.remove();
                }, 500);
            });
        }, 5000);
        document.querySelector('form[action=""]')?.addEventListener('submit', function (e) {
            if (this.querySelector('input[name="update_password"]')) {
                const newPass = this.querySelector('#new_password').value;
                const confirmPass = this.querySelector('#confirm_password').value;

                if (newPass !== confirmPass) {
                    e.preventDefault();
                    alert('Новий пароль та підтвердження не співпадають');
                } else if (newPass.length < 6) {
                    e.preventDefault();
                    alert('Пароль повинен містити не менше 6 символів');
                }
            }
        });
    </script>
</body>

</html>