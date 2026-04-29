<?php
if (!isset($_SESSION['pottery_user']) && isset($_COOKIE['remember_user'])) {
    $userId = $_COOKIE['remember_user'];
    $user = getUserById($pdo, $userId);

    if ($user) {
        $_SESSION['pottery_user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'admin' => $user->admin,
            'email' => $user->email,
            'image' => $user->image
        ];
    }
}
?>
<header>
    <a class="logo" href="<?= $mainDir ?>pages/home.php">Гончарня</a>
    <div class="header-links">
        <a class="header-link" href="<?= $mainDir ?>pages/home.php">ГОЛОВНА</a>
        <a class="header-link" href="<?= $mainDir ?>pages/catalog.php">КАТАЛОГ</a>
        <a class="header-link" href="<?= $mainDir ?>pages/about.php">ПРО НАС</a>
        <a class="header-link" href="<?= $mainDir ?>pages/contacts.php">КОНТАКТИ</a>
    </div>
    <div class="header-right">
        <?php if (isset($_SESSION['pottery_user'])): ?>
            <a class="btn-dark" href="../user/cart.php">🛒 КОШИК</a>

            <div class="user-dropdown">
                <div class="header-user-container">
                    <?php
                    $userImage = $_SESSION['pottery_user']['image'] ?? '';
                    $isExternal = strpos($userImage, 'http') === 0;
                    $localPath = '../public/images/users/' . $userImage;
                    ?>

                    <?php if (!empty($userImage) && ($isExternal || file_exists($localPath))): ?>
                        <img class="header-user-image"
                            src="<?= $isExternal ? htmlspecialchars($userImage) : htmlspecialchars($localPath) ?>"
                            alt="Avatar" />
                    <?php else: ?>
                        <div class="header-user-image default-avatar">👤</div>
                    <?php endif; ?>
                    <div class="header-user-name">
                        <?= htmlspecialchars($_SESSION['pottery_user']['name'] . ' ' . $_SESSION['pottery_user']['surname']) ?>
                    </div>
                    <span class="dropdown-arrow">▼</span>
                </div>
                <div class="user-dropdown-menu">
                    <a href="../user/orders.php" class="dropdown-item">
                        <span class="dropdown-icon">📋</span>
                        Замовлення
                    </a>
                    <a href="../user/settings.php" class="dropdown-item">
                        <span class="dropdown-icon">⚙️</span>
                        Налаштування
                    </a>
                    <?php if (isset($_SESSION['pottery_user']['admin']) && $_SESSION['pottery_user']['admin'] == 1) : ?>
                        <a href="../admin/products.php" class="dropdown-item">
                            <span class="dropdown-icon">🔧</span>
                            Адмін панель
                        </a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a href="../auth/logout.php" class="dropdown-item logout">
                        <span class="dropdown-icon">🚪</span>
                        Вихід
                    </a>
                </div>
            </div>
        <?php else: ?>
            <a class="btn-light" href="<?= $mainDir ?>auth/login.php">ВХІД</a>
            <a class="btn-dark" href="<?= $mainDir ?>auth/registration.php">РЕЄСТРАЦІЯ</a>
        <?php endif; ?>
    </div>
</header>
