<?php

if (isset($_SESSION['auth']) && $_SESSION['auth'] && isset($_COOKIE['login'])) {
    setcookie('login', $_COOKIE['login'], 0, '/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data/main_menu.php';

$pathArr = array_column($menuItems, 'title', 'path');
$textArr = array_column($menuItems, 'text', 'path');
$pagePath = str_replace('index.php', '', $_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="/styles.css" rel="stylesheet">
    <title>Project - ведение списков</title>
</head>
<body>

    <div class="header">
        <div class="logo"><img src="/i/logo.png" width="68" height="23" alt="Project"></div>
        <div class="clearfix"></div>
    </div>

    <div class="clear">
        <ul class="main-menu">
            <?php
            showMenu($menuItems, 'header') ?>
        </ul>
        <?php
        if (isset($_SESSION['auth']) && $_SESSION['auth']) {
            echo '<a href="/?login=no" class="auth">Выйти</a>';
            echo '<a href="/profile" class="auth">Мой профиль</a>';
            echo '<a href="/posts" class="auth">Мои сообщения</a>';
        } else {
            echo '<a href="?login=yes" class="auth">Авторизоваться</a>';
        }
        ?>
    </div>


