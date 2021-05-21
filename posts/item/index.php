<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

mysqli_query(connect(), "UPDATE messages SET read_state = '1' WHERE id = '{$_REQUEST['id']}'");

$messages = getUserMessages($_COOKIE['login']);
$message = array_filter($messages, fn($item) => $item['id'] === $_REQUEST['id'])[0];

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
                <h2><?= $message['subject'] ?></h2>
                <small><?= $message['sent_time'] ?></small>
                <p>От: <?= "<b>${message['author']}</b> (${message['author_mail']})" ?></p>
                <hr>
                <p><?= $message['body'] ?></p>
            </td>
        </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
mysqli_close(connect());
