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

                        <?php

                        $userImage = $user->image ?? '';

                        $isExternal = strpos($userImage, 'http') === 0;

                        $localPath = '../public/images/users/' . $userImage;

                        ?>

                        <?php if (!empty($userImage) && ($isExternal || file_exists($localPath))): ?>

                            <img src="<?= $isExternal ? htmlspecialchars($userImage) : htmlspecialchars($localPath) ?>"

                                alt="Avatar">

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



виправ тут загрузку аватарки не через php в imgbb а через js. ось приклад робочої загрузки з іншого файла.

<?php

session_start();

$mainDir = '../';

include('../config/connectDB.php');

include('../templates/helper.php');

include('../models/product.php');

if (!isset($_SESSION['pottery_user']) || $_SESSION['pottery_user']['admin'] != 1) {

    header('Location: ../pages/home.php');

    exit;

}

$name = '';

$category = 1;

$style = 1;

$color = 1;

$description = '';

$price = '';

$weight = '';

$height = '';

$temp = '';

$diameter = '';

$volume = '';

$amount = 0;

$image = 'default.png';



if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $product = getProduct($pdo, $id);

    $name = $product->name;

    $category = $product->ctid;

    $style = $product->sid;

    $color = $product->cid;

    $description = $product->description;

    $weight = $product->weight;

    $height = $product->height;

    $temp = $product->temperature;

    $diameter = $product->diameter;

    $volume = $product->volume;

    $amount = $product->amount;

    $price = $product->price;

    $image = $product->image;

}

$categories = getCategories($pdo);

$colors = getColors($pdo);

$styles = getStyles($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];

    $category = $_POST['category'];

    $color = $_POST['color'];

    $style = $_POST['style'];

    $price = $_POST['price'];

    $description = $_POST['description'];

    $weight = $_POST['weight'];

    $temp = $_POST['temp'];

    $diameter = $_POST['diameter'];

    $height = $_POST['height'];

    $volume = $_POST['value'];

    $amount = $_POST['amount'];

    $imageName = $_POST['current_image'] ?? 'default.png';



    if (isset($_GET['edit'])) {

        updateProduct($pdo, $_GET['edit'], $name, $category, $color, $style, $price, $description, $weight, $temp, $diameter, $height, $volume, $amount, $imageName);

    } else {

        createProduct($pdo, $name, $category, $color, $style, $price, $description, $weight, $temp, $diameter, $height, $volume, $amount, $imageName);

    }

    header('Location: products.php');

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

        <?php include('sidepanel.php') ?>

        <form id="product-form" method="POST" class="vertical full"

            style="padding:20px; padding-left:0px;">

            <!-- URL зображення після завантаження на imgbb -->

            <input type="hidden" name="current_image" id="current_image" value="<?= $image ?>">

            <div class="input-full-container center">

                <label class="input-label">Фото виробу</label>

                <div class="image-upload-wrapper" onclick="document.getElementById('image-input').click()">

                    <img id="image-preview" src="<?= (strpos($image, 'http') === 0)

                        ? $image

                        : "../public/images/pottery/" . $image ?>" class="product-a-c-i">

                    <div class="upload-overlay">

                        <span id="upload-overlay-text">Змінити фото</span>

                    </div>

                </div>

                <!-- НЕ в формі, просто для вибору файлу -->

                <input type="file" id="image-input" accept="image/*" style="display: none;">

            </div>

            <div class="horizontal">

                <?php create_input('Назва продукту', 'name', 'name', 'text', false, 'Назва', $name, true);

                create_input('Кількість', 'amount', 'amount', 'text', false, 'Кількість', $amount, true)

                    ?>

            </div>

            <div class="horizontal">

                <div class="input-full-container">

                    <label class="input-label" for="category">Категорія</label>

                    <div class="custom-select">

                        <select id='category' name="category">

                            <?php foreach ($categories as $c) { ?>

                                <option value='<?= $c->id ?>' <?= $c->id == $category ? 'selected' : '' ?>><?= $c->name ?></option>

                            <?php } ?>

                        </select>

                    </div>

                </div>

                <div class="input-full-container">

                    <label class="input-label" for="color">Колір</label>

                    <div class="custom-select">

                        <select id='color' name="color">

                            <?php foreach ($colors as $c) { ?>

                                <option value='<?= $c->id ?>' <?= $c->id == $color ? 'selected' : '' ?>><?= $c->name ?></option>

                            <?php } ?>

                        </select>

                    </div>

                </div>

            </div>

            <div class="horizontal">

                <div class="input-full-container">

                    <label class="input-label" for="style">Стиль</label>

                    <div class="custom-select">

                        <select name="style" id="style">

                            <?php foreach ($styles as $s) { ?>

                                <option value='<?= $s->id ?>' <?= $s->id == $style ? 'selected' : '' ?>><?= $s->name ?></option>

                            <?php } ?>

                        </select>

                    </div>

                </div>

                <?php create_input('Ціна', 'price', 'price', 'text', false, 'Ціна', $price, true); ?>

            </div>

            <div class="input-full-container">

                <label class="input-label" for="description">Опис</label>

                <textarea name="description"><?= $description ?></textarea>

            </div>

            <div class="line"></div>

            <div class="horizontal">

                <?php

                create_input('Вага', 'weight', 'weight', 'text', false, 'Вага', $weight, false);

                create_input('Температура', 'temp', 'temp', 'text', false, 'Температура', $temp, false);

                create_input('Діаметр', 'diameter', 'diameter', 'text', false, 'Діаметр', $diameter, false);

                create_input('Висота', 'height', 'height', 'text', false, 'Висота', $height, false);

                create_input('Об\'єм', 'value', 'value', 'text', false, 'Об\'єм', $volume, false);

                ?>

            </div>

            <button id="submit-btn" class="clay-btn">Зберегти</button>

        </form>

    </main>

    <script>

        const IMGBB_KEY = '<?= getenv('IMG') ?>';

        const numericFields = ['weight', 'temp', 'diameter', 'height', 'value', 'amount', 'price'];



        document.addEventListener('input', function (e) {

            if (numericFields.includes(e.target.name)) {

                e.target.value = e.target.value.replace(/\D/g, '');

            }

        });



        document.getElementById('image-input').addEventListener('change', async function (event) {

            const file = event.target.files[0];

            if (!file) return;



            const reader = new FileReader();

            reader.onload = e => {

                document.getElementById('image-preview').src = e.target.result;

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



        document.getElementById('product-form').addEventListener('submit', function (e) {

            const overlayText = document.getElementById('upload-overlay-text');

            if (overlayText.textContent === 'Завантаження...') {

                e.preventDefault();

                alert('Зачекайте, фото ще завантажується...');

                return;

            }

            const btn = document.getElementById('submit-btn');

            btn.disabled = true;

            btn.innerText = 'Збереження...';

            btn.style.opacity = '0.7';

            btn.style.cursor = 'not-allowed';

        });

    </script>

</body>



</html> 

