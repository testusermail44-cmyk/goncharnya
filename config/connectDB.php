<?php
    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    $pdo = new PDO(
    $host,
    $user,
    $pass,   
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
?>
