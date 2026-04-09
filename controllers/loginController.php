<?php
session_start();
include('../config/connectDB.php');
include('../templates/helper.php');
include('../models/user.php');
$mainDir = '../';
$error = '';
$email = '';
$password = '';
$remember = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = $_POST['remember'] ?? false;
    if (loginUser($pdo, $email, $password, $remember)) {
        header('Location: ../pages/home.php');
        exit();
    }
    else {
        $error = 'Email або пароль не правильний';
    }
}
?>