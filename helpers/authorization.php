<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/data/logins.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data/passwords.php';
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
        $userPass = clean($userPass);
        $authorization = $_SESSION['auth'] = in_array($userLogin, $logins) && $passwords[$userLogin] === $userPass;
        setcookie('login', $userLogin, 0, '/');
        if ($authorization) {
            header('Location: /');
        }
    }
}
if (isset($_GET['login']) && $_GET['login'] === 'no') {
    $authorization = false;
    unset($_SESSION['auth']);
}

