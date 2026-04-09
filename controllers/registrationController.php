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
    if ($password !== $confirm) {
        $error = "Паролі не співпадають";
    }
    if (checEmail($pdo, $email)) {
        $error = 'Такий Email вже використовується';
    }
    if ($password == $confirm && strlen($password) >= 6) {
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