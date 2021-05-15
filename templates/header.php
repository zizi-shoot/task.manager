<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data/main_menu.php';

$pathArr = array_column($menuItems, 'title', 'path');
$pagePath = str_replace('index.php', '', $_SERVER['REQUEST_URI']);

if ((isset($_SESSION['auth']) && $_SESSION['auth']) && $pagePath === '/route/profile/') {
    $userData = getUserData($_COOKIE['login']);
    if (isset($userData)) {
        $fullName = $userData[0]['full_name'];
        $email = $userData[0]['e_mail'];
        $phone = $userData[0]['phone'];
        $agreement = $userData[0]['agreement'];
        $state = $userData[0]['state'];
        $groups = [];
        foreach ($userData as $row) {
            $groups[$row['group_name']] = $row['group_description'];
        }
    }
}
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
            echo '<a href="/route/profile/" class="auth">Мой профиль</a>';
        } else {
            echo '<a href="?login=yes" class="auth">Авторизоваться</a>';
        }
        ?>
    </div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
                <?php
                if (in_array($pagePath, ['/?login=yes', '/?login=no', '/'])): ?>
                    <h1>Главная</h1>
                    <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>
                <?php
                elseif ($pagePath === '/route/profile/'): ?>
                    <h1>Мой профиль</h1>
                    <ul class="profile-list">
                        <li><b>ФИО:</b> <?= $fullName ?? '' ?></li>
                        <li><b>E-mail:</b> <?= $email ?? '' ?></li>
                        <li><b>Телефон:</b> <?= $phone ?? '' ?></li>
                        <li><b><?= $agreement ?? '' ?></b> получать уведомления</li>
                        <li><b>Состояние:</b> <?= $state ?? '' ?></li>
                        <li><b>Группы пользователя:</b>
                            <ul>
                                <?php
                                if (isset($groups)) {
                                    foreach ($groups as $name => $descr) {
                                        echo "<li>$name ($descr)</li>";
                                    }
                                } ?>
                            </ul>
                        </li>
                    </ul>

                <?php
                else: ?>
                    <h1><?= $pathArr[$pagePath] ?></h1>
                    <p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p>
                <?php
                endif; ?>

            </td>
