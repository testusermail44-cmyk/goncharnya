<?php
include('../controllers/checkoutController.php');
?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Оформлення</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main>
        <form class="horizontal main-padding main-check" method="post">
            <div class="check-left">
                <div class="check-panel">
                    <div class="check-label-container">
                        <div class="check-label-panel">👤</div>
                        <div class="check-label">Контактні дані</div>
                    </div>
                    <div class="check-inputs">
                        <?php
                        create_input("Ім'я", "name", "name", "text", "👤", "Ім'я", $_SESSION['pottery_user']['name'], true);
                        create_input("Прізвище", "surname", "surname", "text", "👤", "Прізвище", $_SESSION['pottery_user']['surname'], true);
                        ?>
                    </div>
                    <div class="check-inputs">
                        <?php
                        create_input("Телефон", "phone", "phone", "text", "📞", "Формат: 0123456789", '', true);
                        create_input("Email", "email", "email", "email", "✉️", "Email", $_SESSION['pottery_user']['email'], true);
                        ?>
                    </div>
                </div>
                <div class="check-panel">
                    <div class="check-label-container">
                        <div class="check-label-panel">🚚</div>
                        <div class="check-label">Спосіб доставки</div>
                    </div>
                    <div class="vertical">
                        <label class="delivery-option">
                            <input type="radio" name="delivery" checked class="radio" id="np" value="1"/>
                            <div class="delivery-info">
                                <div class="dot"></div>
                                <div class="del-name">Нова пошта</div>
                                <div class="small-text del">1-3 робочих днів</div>
                            </div>
                            <div class="del-price">80 грн</div>
                        </label>
                        <label class="delivery-option">
                            <input type="radio" name="delivery" class="radio" id="up" value="2"/>
                            <div class="delivery-info">
                                <div class="dot"></div>
                                <div class="del-name">Укр пошта</div>
                                <div class="small-text del">3-7 робочих днів</div>
                            </div>
                            <div class="del-price">60 грн</div>
                        </label>
                        <?php
                        create_input("Місто", "city", "city", "text", "🏙️", "Місто", '', true);
                        create_input("Віділення або адреса", "department", "department", "text", "🏬", "Віділення", '', true);
                        ?>
                    </div>

                </div>
                <div class="check-panel">
                    <div class="check-label-container">
                        <div class="check-label-panel">💳</div>
                        <div class="check-label">Спосіб оплати</div>
                    </div>
                    <div class="horizontal center">
                        <label class="pay-panel">
                            <input type="radio" name="payment" checked class="radio" value="1"/>
                            <div class="pay-icon">📦</div>
                            <div class="pay-text p">Накладний платіж</div>
                        </label>
                        <label class="pay-panel">
                            <input type="radio" name="payment" class="radio" value="2"/>
                            <div class="pay-icon">🏦</div>
                            <div class="pay-text p">Переказ на рахунок</div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="check-right">
                <div class="check-panel">
                    <h2>Ваше замовлення</h2>
                    <div class="checkout-i">
                        <div class="check-i">Підсумок</div>
                        <div class="check-p" id="res">
                            <?php
                            $resPrice = 0;
                            foreach($products as $p):
                            $count = 0;
                            foreach ($_SESSION['cart'] as $item)
                                if ($p->id == $item['product']):
                                    $count = $item['count'];
                                    break;
                                endif;
                            $resPrice += $p->price * $count;
                            endforeach; 
                            ?>
                        <?=$resPrice?></div>
                    </div>
                    <div class="checkout-i">
                        <div class="check-i">Доставка</div>
                        <div id="delivery-div" class="check-p">80 грн</div>
                    </div>
                    <div class="line"></div>
                    <h1 class="res-pr" id="res-p">Загальна ціна: <?=$resPrice + 80?></h1>
                    <input type="hidden" name="price" value="<?=$resPrice + 80?>"/>
                    <button class="clay-btn check-btn">Підтвердити замовлення</button>
                </div>
            </div>
        </form>
    </main>
    <?php
    include('../templates/footer.php');
    ?>
<script>
    let delivery = document.getElementById('delivery-div');
    let np = document.getElementById('np');
    let up = document.getElementById('up');
    let res = document.getElementById('res');
    let resp = document.getElementById('res-p');
    function updatePrice() {
        if (np.checked) {
            delivery.innerHTML = '80 грн';
            resp.innerHTML = 'Загальна вартість: ' + (Number(res.innerHTML) + 80);
        } else if (up.checked) {
            delivery.innerHTML = '60 грн';
            resp.innerHTML = 'Загальна вартість: ' + (Number(res.innerHTML) + 60);
        }
    }
    np.addEventListener('change', updatePrice);
    up.addEventListener('change', updatePrice);

    const phoneInput = document.getElementById('phone');
    const form = document.querySelector('form');
    phoneInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
    form.addEventListener('submit', function(e) {
        const phoneValue = phoneInput.value;
        if (phoneValue.length < 10) {
            e.preventDefault();
            alert('Номер телефону має містити рівно 10 цифр (наприклад: 0501234567)');
            phoneInput.focus();
        }
    });
</script>
</body>

</html>