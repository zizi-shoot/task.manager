<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
                <form action="" method="post" style="display: flex; flex-direction: column; max-width: 500px;">
                    <label for="title">Заголовок:</label>
                    <input type="text" name="title" id="title">
                    <label for="subject">Сообщение:</label>
                    <textarea name="subject" id="subject"></textarea>
                    <label for="recipient_id">Кому:</label>
                    <select name="recipient_id" id="recipient_id">
                        <option value="6">Максимов Леонид Александрович</option>
                    </select>
                    <label for="section_id">Раздел:</label>
                    <select name="section_id" id="section_id">
                        <option value="1">Основные</option>
                        <option value="2">&nbsp;&nbsp;по работе</option>
                        <option value="3">&nbsp;&nbsp;личные</option>
                        <option value="4">Оповещения</option>
                        <option value="5">&nbsp;&nbsp;форумы</option>
                        <option value="6">&nbsp;&nbsp;магазины</option>
                        <option value="7">&nbsp;&nbsp;подписки</option>
                        <option value="8">Спам</option>
                    </select>
                    <button type="submit">Отправить</button>
                </form>
            </td>
        </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
