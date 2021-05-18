<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

$messages = getUserMessages('ag.dorofeev@gmail.com');
var_dump($messages);

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index messages">
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
        </td>
    </tr>
</table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';

?>




