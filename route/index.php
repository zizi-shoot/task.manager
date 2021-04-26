<?php

session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] && isset($_COOKIE['login'])) {
    setcookie('login', $_COOKIE['login'], 0, '/');
}

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
