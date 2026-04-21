<?php
session_start();
include('../config/connectDB.php');
include('../templates/helper.php');
include('../models/user.php');
$mainDir = '../';
$error = '';
$name = '';
$surname = '';
$email = '';
$password = '';
$confirm = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if (strlen($password) < 6) {
        $error = "Пароль повинен містити мінімум 6 символів";
    }
    else if ($password !== $confirm) {
        $error = "Паролі не співпадають";
    }
    else if (checkEmail($pdo, $email)) {
        $error = 'Такий Email вже використовується';
    }
    else {
        if (addUser($pdo, $name, $surname, $password, $email)){
            header('Location: login.php');
            exit;
        }
        else{
            $error = 'Виникла помилка ☹️';
        }
    }
}
?>