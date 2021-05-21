<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

$userData = getUserData($_COOKIE['login']);
if (empty(array_filter($userData, fn($item) => $item['group_name'] === 'Блогер'))) {
    $warningMessage = 'Вы сможете отправлять сообщения после прохождения модерации';
}

$messages = getUserMessages($_COOKIE['login']);

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index messages">
                <?php
                if (isset($warningMessage)) {
                    echo "<p style='font-weight: bold; color: red;'>$warningMessage</p>";
                } else { ?>
                    <h2 class="messages__title">Непрочитанные</h2>
                    <ul class="messages__list">
                        <?php
                        renderMessages($messages, '0') ?>
                    </ul>
                    <h2 class="messages__title">Прочитанные</h2>
                    <ul class="messages__list">
                        <?php
                        renderMessages($messages, '1') ?>
                    </ul>
                    <a href="add" class="messages messages_add">Написать сообщение</a>
                    <?php
                } ?>
            </td>
        </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
mysqli_close(connect());




