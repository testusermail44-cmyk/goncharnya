<?php
function product_card($id, $image, $name, $category, $price)
{
    ?>
    <a href="product.php?id=<?= $id ?>" class="product-card">
        <div class='product-image-card-cont <?= random_int(0, 1) == 0 ? 'green' : 'brown' ?>'>
            <img class="product-card-image" src="<?= (strpos($image, 'http') === 0)
                ? $image
                : "../public/images/pottery/" . $image ?>"
                onerror="this.onerror=null; this.src='../public/images/pottery/default.png';" />
        </div>
        <div class="product-card-container">
            <span class="card-category"><?= $category ?></span>
            <span class="card-name"><?= $name ?></span>
            <span class="card-price"><?= $price ?></span>
        </div>
        <div class="btn-form">
            <button class="btn-dark">Переглянути</button>
        </div>
    </a>
    <?php
}

function createCartCard($id, $name, $price, $volume, $color, $categoty, $image, $count)
{
    ?>
    <div class="cart-card">
        <div class="card-left">
            <div class="cart-img">
                <img class="cart-image" src="<?= (strpos($image, 'http') === 0)
                    ? $image
                    : "../public/images/pottery/" . $image ?>"
                    onerror="this.onerror=null; this.src='../public/images/pottery/default.png';" />
            </div>
            <div class="vertical cart-info">
                <div class="info-label"><?= $categoty ?></div>
                <div class="cart-name"><?= $name ?></div>
                <div class="small-text"><?= $color . ' ' . $volume / 1000 ?> л</div>
                <div class="cart-price"><?= $price ?> грн</div>
            </div>
        </div>
        <div class="card-right">
            <div class="card-item-count">
                <?= $count ?> шт.
            </div>
            <div class="cart-item-res-price">
                <?= $price * $count ?> грн
            </div>
            <a class="cart-del-btn" href="?del=<?= $id ?>">Видалити</a>
        </div>
    </div>
    <?php
}

function create_input($labelText, $name, $id, $type, $icon, $placeholder, $value = null, $require = false)
{
    ?>
    <div class="input-full-container">
        <label class="input-label" for="<?= $id ?>"><?= $labelText ?></label>
        <div class="input-container">
            <?php if (!$icon) { ?>
                <div class="input-icon"><?= $icon ?></div>
            <?php } ?>
            <input id="<?= $id ?>" name="<?= $name ?>" <?= $value ? 'value="' . $value . '"' : '' ?> type="<?= $type ?>"
                placeholder="<?= $placeholder ?>" autocomplete="off" <?= $require ? 'required' : '' ?> />
        </div>
    </div>
    <?php
}

function custom_checkbox($name, $value, $text, $checked = false)
{
    ?>
    <label class="checkbox-container"><?= $text ?>
        <input type="checkbox" name="<?= $name ?>" value="<?= $value ?>" <?= $checked ? 'checked' : '' ?>>
        <span class="checkmark"></span>
    </label>
    <?php
}

function createPages($number, $page)
{
    $pages = ceil($number / 9);
    ?>
    <div class="pages-container">
        <?php for ($i = 1; $i <= $pages; $i++):
            if ($pages <= 10 || $i == 1 || $i == $pages || abs($i - $page) <= 1):
                $query = $_GET;
                if ($i == 1) {
                    unset($query['page']);
                } else {
                    $query['page'] = $i;
                }
                ?>
                <a class="page <?= $i == $page ? 'active' : '' ?>" href="?<?= http_build_query($query) ?>">
                    <?= $i ?>
                </a>
                <?php
            elseif ($i == 2 && $page > 3 || $i == $pages - 1 && $page < $pages - 2):
                echo '<span class="page">...</span>';
            endif;

        endfor; ?>
    </div>
    <?php
}
?>