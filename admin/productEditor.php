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
