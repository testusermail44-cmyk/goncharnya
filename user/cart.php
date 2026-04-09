<?php
   require_once '../controllers/cartController.php';
   $resPrice = 0;
?>
<html lang="uk">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../public/css/style.css" />
        <title>Кошик</title>
    </head>
    <body>
        <?php
            include('../templates/header.php');
        ?>
            <main class="cart-main">
                <?php if(count($products) > 0){?>
                <div class="cart-container">
                    <?php
                        foreach($products as $p):
                            $count = 0;
                            foreach ($_SESSION['cart'] as $item)
                                if ($p->id == $item['product']):
                                    $count = $item['count'];
                                    break;
                                endif;
                            createCartCard($p->id, $p->name, $p->price, $p->volume, $p->color, $p->category, $p->image, $count);
                            $resPrice += $p->price * $count;
                        endforeach;
                    ?>
                </div>
                 <div class="order-info-cart">
                    <h2>Підсумок замовлення</h2>
                    <div class="line"></div>
                    <form class="cart-form" method="post" action="../pages/checkout.php">
                        <div class="result-price">
                            <div class="res-p">Разом</div>
                            <div class="res-price"><?=$resPrice?> грн</div>
                            <input type="hidden" value="<?=$resPrice?>" />
                        </div>
                        <button class="clay-btn">Оформити замовлення</button>
                    </form>
                </div>
                <?php }
                    else{
                        ?>
                        <div class="vertical center c">
                            <div class="empty-cart">🛒</div>
                            <div class="empty-cart-text">Ваш кошик порожній! Для оформлення замовлення додайте товари до кошику</div>
                        </div>
                        <?php
                        }?>
            </main>     
        <?php
            include('../templates/footer.php');
        ?>
    </body>
</html> 