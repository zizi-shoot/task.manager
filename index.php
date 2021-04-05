<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/include/logins.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/passwords.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/data/main_menu.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

$userLogin = $_POST['login'] ?? null;
$userPass = $_POST['password'] ?? null;
$authorization = false;
$form = false;

function clean($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}

if (isset($_GET['login']) && $_GET['login'] === 'yes') {
    $form = true;

    if (isset($userLogin) && isset($userPass)) {
        $userLogin = clean($userLogin);
        $userPass = clean($userPass);
        $authorization = in_array($userLogin, $logins) && $passwords[$userLogin] === $userPass;
    }
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>




<?php
if ($form && !$authorization) { ?>
    <td class="right-collum-index">

        <div class="project-folders-menu">
            <ul class="project-folders-v">
                <li class="project-folders-v-active"><a href="#">Авторизация</a></li>
                <li><a href="#">Регистрация</a></li>
                <li><a href="#">Забыли пароль?</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="index-auth">
            <form action="/?login=yes" method="POST">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="iat">
                            <label for="login_id">Ваш e-mail:</label>
                            <input id="login_id" size="30" name="login">
                        </td>
                    </tr>
                    <tr>
                        <td class="iat">
                            <label for="password_id">Ваш пароль:</label>
                            <input id="password_id" size="30" name="password" type="password">
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Войти"></td>
                    </tr>
                </table>
            </form>
            <?php
            if (isset($userLogin) || isset($userPass)) { ?>
                <p class="error">Неверный логин или пароль</p>
                <?php
            } ?>
        </div>

    </td>
    <?php
} ?>

</tr>
</table>
<?php
if ($authorization) {
    include_once 'include/success.php';
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>



