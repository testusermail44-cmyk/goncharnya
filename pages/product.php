<?php
require_once('../controllers/productController.php');
?>
<html lang="uk">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../public/css/style.css" />
    <title>Продукт "<?= $product->name ?>"</title>
</head>

<body>
    <?php
    include('../templates/header.php');
    ?>
    <main class="vertical-main">
        <div class="product-view">
            <div class="product-image-panel">
                <img class="product-image" src="../public/images/pottery/<?= $product->image ?>"
                    onerror="this.onerror=null; this.src='../public/images/pottery/default.png';" />
            </div>
            <div class="product-right">
                <span class="info-text-product"><?= $product->category ?> ◆ <?= $product->style ?></span>
                <h1 class="dark"><?= $product->name ?></h1>
                <div>
                    <span class="info-about-product">Переглядів: <?= $product->views ?></span>
                </div>
                <div class="product-price"><?= $product->price ?> грн</div>
                <div class="line"></div>
                <div class="text"><?= $product->description ?></div>
                <div class="small-info">Колір глини</div>
                <div class="color-cont">
                    <div class="color-circle" style="background: <?= $product->color ?>;"></div>
                    <div class="text"><?= $product->color_name ?></div>
                </div>
                <?php if ($product->volume != 0): ?>
                    <div class="small-info">Об'єм</div>
                    <div class="volume"><?= $product->volume / 1000 ?> л</div>
                <?php endif; ?>
                <div class="line"></div>
                <form class="vertical" method="post">
                    
                        <?php if($product->amount > 0){?>
                            <div class="counter">
                                <div class="counter-container">
                                    <button type='button' id="minus" class="counter-btn">-</button>
                                    <input class="counter-input" type="text" name="counter" value="1" />
                                    <button type='button' id="plus" class="counter-btn">+</button>
                                </div>
                                <div class="stock">В наявності: <?= $product->amount ?> шт.</div>
                            </div>
                            <button class="clay-btn cart-btn" name="product" value="<?=$_GET['id']?>" type="submit">🛒 ДОДАТИ ДО КОШИКА</button>
                        <?php }
                        else{
                        ?>
                            <div class="stock">Немає в наявності</div>
                            <div class="clay-btn cart-btn inactive">🛒 ДОДАТИ ДО КОШИКА</div>
                        <?php
                        } ?>
                    </div>
                    
                    
                </form>
            </div>
        </div>
        <div class="vertical">
            <div class="line m"></div>
            <div class="small-info ml">Характеристики</div>
            <div class="characteristics-container">
                <div class="characteristics">Висота: <?= $product->height ?> см</div>
                <div class="characteristics">Вага: <?= $product->weight ?> г</div>
                <div class="characteristics">Діаметр: <?= $product->diameter ?> см</div>
                <?php if ($product->temperature != 0): ?>
                    <div class="characteristics">Температура: до <?= $product->temperature ?> °C</div>
                <?php endif; ?>
            </div>
            <div class="line m"></div>
            <?php if (count($reviews) > 0) { ?>
                <div class="comments">
                    <?php foreach ($reviews as $r): ?>
                        <div class="review-container">
                            <div class="user-review-container">
                                <img class="user-circle-review" src="../public/images/users/<?= $r->image ?>" />
                                <div class="review-user-info">
                                    <div class='review-i'>
                                        <span class="user-name-review"><?= $r->name . ' ' . $r->surname ?></span>
                                        <div class='horizontal'>
                                            <span class="user-time-review<?=$_SESSION['pottery_user']['id'] == $r->user || $_SESSION['pottery_user']['admin'] == 1 ? '-margin' : ''?>"><?=$r->date?></span>
                                            <?php if ($_SESSION['pottery_user']['id'] == $r->user || $_SESSION['pottery_user']['admin'] == 1) {
                                                ?>
                                                <a class="clay-btn rev" href="?<?= $_SERVER['QUERY_STRING'] ?>&del=<?=$r->id?>">🗑️</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="rating-container">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <div class="rating-btn-div <?=$i < $r->rating ? 'star' : '' ?>">★</div>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="review-body"><?=$r->text?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php } else { ?>
                <div class="text-info">Коментарів ще немає!</div><?php } ?>
            <div class="line m"></div>
            <?php if (isset($_SESSION['pottery_user'])) { ?>
                <form class='review-form' method="post">
                    <div class="user-review-container">
                        <img class="user-circle-review"
                            src="../public/images/users/<?= $_SESSION['pottery_user']['image'] ?>" />
                        <div class="review-user-info">
                            <span
                                class="user-name-review"><?= $_SESSION['pottery_user']['name'] . ' ' . $_SESSION['pottery_user']['surname'] ?></span>
                            <div class="rating-container">
                                <button type='button' class="rating-btn">★</button>
                                <button type='button' class="rating-btn">★</button>
                                <button type='button' class="rating-btn">★</button>
                                <button type='button' class="rating-btn">★</button>
                                <button type='button' class="rating-btn">★</button>
                                <input type="hidden" name="rating" id="rating" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="text-review">
                        <textarea name="review"></textarea>
                        <button class='clay-btn' type="submit">➤</button>
                    </div>

                </form>
            <?php } else {
                ?>
                <div class="text-info mb">Залишати коментарі можуть тільки зареєстровані користувачі</div>
            <?php } ?>
        </div>

    </main>
    <?php
    include('../templates/footer.php');
    ?>
    <script>
        let maxAmount = <?= $product->amount ?>
    </script>
    <script src="../public/js/counter.js"></script>
    <script>
        let ratingInput = document.getElementById('rating')
        let ratingButtons = document.querySelectorAll('.rating-btn')
        ratingButtons.forEach((element, index) => {
            element.addEventListener('mouseenter', (e) => {
                for(let i = 0; i < 5; i++) {
                    ratingButtons[i].style.color = 'gray'
                }
                for (let i = 0; i <= index; i++) {
                    ratingButtons[i].style.color = '#ffd000'
                }
            })
            element.addEventListener('mouseleave', (e) => {
                for (let i = 0; i < 5; i++) {
                    if (Number(ratingInput.value) >= i+1)
                        ratingButtons[i].style.color = '#ffd000'
                    else
                        ratingButtons[i].style.color = 'gray'
                }
            })
            element.addEventListener('click', (e) => {
                rating.value = index + 1
            })
        })
    </script>
</body>

</html>