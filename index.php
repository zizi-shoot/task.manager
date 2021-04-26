<?php

session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] && isset($_COOKIE['login'])) {
    setcookie('login', $_COOKIE['login'], 0, '/');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/authorization.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

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
                            <label for="login_id">Ваш логин:<?= isset($_COOKIE['login']) ? " {$_COOKIE['login']}" : null ?></label>
                            <input style="visibility: <?= isset($_COOKIE['login']) ? 'hidden' : 'visible' ?>;" id="login_id" size="30" name="login">
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
            if (isset($userLogin) && !isset($_COOKIE['login']) || isset($userPass)) { ?>
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

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>



