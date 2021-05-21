<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

if ((isset($_SESSION['auth']) && $_SESSION['auth'])) {
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

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index">
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
            </td>
        </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
mysqli_close(connect());
