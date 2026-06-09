<?php
session_start();
$mainDir = '../';
if (!isset($_SESSION['pottery_user']) || !isset($_SESSION['pottery_user']->id)) {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../config/connectDB.php';
require_once '../models/user.php';

$userId = $_SESSION['pottery_user']->id;
$message = '';
$error = '';

$user = getUserById($pdo, $userId);
$userImage = $user->image;
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
    $avatarUrl = $_POST['avatar_url'] ?? '';

    if (!empty($avatarUrl)) {
        $result = updateUserAvatar($pdo, $userId, $avatarUrl, $user->image);

        if ($result['success']) {
            header('Location: settings.php');
            exit;
        } else {
            $error = $result['message'];
        }
    } else {
        $error = 'Не вдалося отримати посилання на зображення';
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
                        <?php
                        $userImage = $user->image ?? '';
                        $isExternal = is_string($userImage) && strpos($userImage, 'http') === 0;
                        $localPath = '../public/images/users/' . (is_string($userImage) ? $userImage : '');
                        ?>
                        <?php if (!empty($userImage) && is_string($userImage) && ($isExternal || file_exists($localPath))): ?>
                            <img id="image-preview" src="<?= $isExternal ? htmlspecialchars($userImage) : htmlspecialchars($localPath) ?>"
                                alt="Avatar">
                        <?php else: ?>
                            <div id="avatar-placeholder" class="no-avatar">👤</div>
                            <img id="image-preview" src="" alt="Avatar" style="display: none;">
                        <?php endif; ?>
                    </div>
                    <div class="avatar-actions">
                        <form id="avatar-form" method="POST">
                            <div class="file-input-wrapper">
                                <button type="button" class="clay-btn"
                                    onclick="document.getElementById('avatar-input').click()">
                                    Завантажити фото
                                </button>
                                <div id="upload-overlay-text" style="margin-top: 5px; font-size: 14px; color: var(--text-color);"></div>
                                <input type="hidden" name="avatar_url" id="current_image" value="">
                                <input type="hidden" name="update_avatar" value="1">
                            </div>
                        </form>
                        <input type="file" id="avatar-input" accept="image/*" style="display: none;">

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
        const IMGBB_KEY = '<?= getenv('IMG') ?>';

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

        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function (e) {
                if (this.querySelector('#new_password')) {
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
        });

        document.getElementById('avatar-input').addEventListener('change', async function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const previewImg = document.getElementById('image-preview');
            const placeholder = document.getElementById('avatar-placeholder');

            const reader = new FileReader();
            reader.onload = e => {
                if(placeholder) placeholder.style.display = 'none';
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            };
            reader.readAsDataURL(file);

            const overlayText = document.getElementById('upload-overlay-text');
            overlayText.textContent = 'Завантаження...';

            try {
                const base64 = await toBase64(file);
                const formData = new FormData();
                formData.append('image', base64.split(',')[1]);

                const res = await fetch('https://api.imgbb.com/1/upload?key=' + IMGBB_KEY, {
                    method: 'POST',
                    body: formData,
                });
                const data = await res.json();

                if (data?.data?.url) {
                    document.getElementById('current_image').value = data.data.url;
                    overlayText.textContent = 'Завантажено ✓';
                    document.getElementById('avatar-form').submit();
                } else {
                    overlayText.textContent = 'Помилка завантаження';
                    console.error(data);
                }
            } catch (err) {
                overlayText.textContent = 'Помилка завантаження';
                console.error(err);
            }
        });

        function toBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }
    </script>
</body>

</html>
