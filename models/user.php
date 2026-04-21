<?php
function getUsers($pdo){
    $stmt = $pdo->prepare("SELECT name, surname, email, admin, image FROM users");
    $stmt->execute();
    return $stmt->fetchAll();
}
function checkEmail($pdo, $email){
    $stmt = $pdo->prepare("SELECT email FROM users WHERE EMAIL = ?");
    $stmt->execute([$email]);
    return (bool)$stmt->fetch();
}
function addUser($pdo, $name, $surname, $pass, $email)
{
    $password = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, surname, password, email) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $surname, $password, $email])) {
        return true;
    } else {
        return false;
    }
}

function loginUser($pdo, $email, $pass, $remember = false)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if (!$user) {
        return false;
    }
    if (!password_verify($pass, $user->password)) {
        return false;
    }
    $_SESSION['pottery_user']['id'] = $user->id;
    $_SESSION['pottery_user']['name'] = $user->name;
    $_SESSION['pottery_user']['surname'] = $user->surname;
    $_SESSION['pottery_user']['admin'] = $user->admin;
    $_SESSION['pottery_user']['email'] = $user->email;
    $_SESSION['pottery_user']['image'] = $user->image;
    if ($remember) {
        setcookie(
            "remember_user",
            $user->id,
            time() + (86400 * 30),
            "/"
        );
    }
    return true;
}

function getUserById($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT id, name, surname, email, image, admin FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function updateUserProfile($pdo, $userId, $name, $surname) {
    $stmt = $pdo->prepare("UPDATE users SET name = ?, surname = ? WHERE id = ?");
    if ($stmt->execute([$name, $surname, $userId])) {
        $_SESSION['pottery_user']['name'] = $name;
        $_SESSION['pottery_user']['surname'] = $surname;
        return true;
    }
    return false;
}

function updateUserPassword($pdo, $userId, $currentPassword, $newPassword, $confirmPassword) {
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        return ['success' => false, 'message' => 'Будь ласка, заповніть всі поля'];
    }
    
    if ($newPassword !== $confirmPassword) {
        return ['success' => false, 'message' => 'Новий пароль та підтвердження не співпадають'];
    }
    
    if (strlen($newPassword) < 6) {
        return ['success' => false, 'message' => 'Пароль повинен містити не менше 6 символів'];
    }
    
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch();
    
    if (!password_verify($currentPassword, $userData->password)) {
        return ['success' => false, 'message' => 'Поточний пароль введено невірно'];
    }
    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    if ($stmt->execute([$newHash, $userId])) {
        return ['success' => true];
    }
    
    return ['success' => false, 'message' => 'Помилка при зміні пароля'];
}
function updateUserAvatar($pdo, $userId, $file, $currentImage) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Будь ласка, оберіть файл для завантаження'];
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        return ['success' => false, 'message' => 'Дозволені формати: JPEG, PNG, WEBP'];
    }

    $apiKey = getenv('IMG');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $apiKey);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'image' => base64_encode(file_get_contents($file['tmp_name'])),
    ]);
    
    $response = curl_exec($ch);
    $ch = null;
    $resData = json_decode($response, true);

    if (isset($resData['data']['url'])) {
        $newImageUrl = $resData['data']['url'];

        if ($currentImage && strpos($currentImage, 'http') === false && $currentImage !== 'user.png') {
            $oldPath = '../public/images/users/' . $currentImage;
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $stmt = $pdo->prepare("UPDATE users SET image = ? WHERE id = ?");
        if ($stmt->execute([$newImageUrl, $userId])) {
            $_SESSION['pottery_user']['image'] = $newImageUrl;
            return ['success' => true, 'image' => $newImageUrl];
        }
        return ['success' => false, 'message' => 'Помилка при збереженні фото в БД'];
    }
    
    return ['success' => false, 'message' => 'Помилка при завантаженні на ImgBB'];
}

function deleteUserAvatar($pdo, $userId, $currentImage) {
    if ($currentImage && strpos($currentImage, 'http') === false && $currentImage !== 'user.png') {
        $oldPath = '../public/images/users/' . $currentImage;
        if (file_exists($oldPath)) unlink($oldPath);
    }
    
    $stmt = $pdo->prepare("UPDATE users SET image = 'user.png' WHERE id = ?");
    if ($stmt->execute([$userId])) {
        $_SESSION['pottery_user']['image'] = 'user.png';
        return ['success' => true];
    }
    
    return ['success' => false, 'message' => 'Помилка при видаленні аватара'];
}

if (isset($_POST['update_avatar'])) {
    $result = updateUserAvatar($pdo, $userId, $_FILES['avatar'], $user->image);

    if ($result['success']) {
        header('Location: settings.php');
        exit;
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