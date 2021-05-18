<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

$messages = getUserMessages('ag.dorofeev@gmail.com');

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
                <h2>Цели на год</h2>
                <small>2021-05-15 23:45:36</small>
                <p>От: <b>Филиппов Артем Львович</b> (a.filippov@gmail.com)</p>
                <hr>
                <p>Привет. Сегодня после обеда обсудим годовой план</p>
            </td>
        </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
