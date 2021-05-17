<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_COOKIE['login'])) {
    unset($_SESSION['auth']);
}
$authorization = $_SESSION['auth'] ??= false;
$userLogin = $_COOKIE['login'] ?? ($_POST['login'] ?? null);
$userPass = $_POST['password'] ?? null;
$form = false;

if (isset($_GET['login']) && $_GET['login'] === 'yes') {
    $form = true;

    if (isset($userLogin) && isset($userPass)) {
        $userLogin = clean($userLogin);
        $authorization = $_SESSION['auth'] = password_verify($userPass, getPass($userLogin));
        if ($authorization) {
            setcookie('login', $userLogin, 0, '/');
            header('Location: /');
        }
    }
}
if (isset($_GET['login']) && $_GET['login'] === 'no') {
    $authorization = false;
    unset($_SESSION['auth']);
}


