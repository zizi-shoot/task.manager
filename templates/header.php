<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data/main_menu.php';

$pathArr = array_column($menuItems, 'title', 'path');
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
        } else {
            echo '<a href="?login=yes" class="auth">Авторизоваться</a>';
        }
        ?>
    </div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
                <h1><?= ($pagePath === '/?login=yes' || $pagePath === '/?login=no') ? 'Главная' : $pathArr[$pagePath] ?></h1>
                <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>
            </td>
