<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/functions.php';

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header('Location: /?login=yes');
}

if (!empty($_POST)) {
    $author = getUserData($_COOKIE['login'])[0];
    $errorMessage = insertMessage($_POST, $author['id']);
}

$sections = getSections();
$mainSections = array_filter($sections, fn($section) => !isset($section['parent_id']));
$combinedSections = [];

$incorrectData = isset($errorMessage) ? $_POST : null;
foreach ($mainSections as $mainSection) {
    global $combinedSections;
    $combinedSections[$mainSection['id']] = $mainSection;
    $childSections = array_filter($sections, function ($section)
    {
        global $mainSection;

        return $section['parent_id'] === $mainSection['id'];
    });
    $combinedSections[$mainSection['id']]['child_sections'] = $childSections;
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left-collum-index new_message">
                <form class="new_message__form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" name="message">
                    <label class="new_message__label" for="subject">Заголовок:</label>
                    <input class="new-message__input" type="text" name="subject" id="subject"
                           value="<?= isset($incorrectData) ? $incorrectData['subject'] : null ?>">
                    <label class="new_message__label" for="body">Сообщение:</label>
                    <textarea class="new-message__input" name="body" id="body"><?= isset($incorrectData) ? $incorrectData['body'] : null ?></textarea>
                    <label class="new_message__label" for="recipient_id">Кому:</label>
                    <select class="new-message__input" name="recipient_id" id="recipient_id">
                        <?php
                        foreach (getRecipients() as $recipient) {
                            $selectedState = null;
                            if (isset($incorrectData) && $recipient['id'] === $incorrectData['recipient_id']) {
                                $selectedState = 'selected';
                            }
                            echo "<option $selectedState value=\"${recipient['id']}\">${recipient['full_name']}</option>";
                        } ?>
                    </select>
                    <label class="new_message__label" for="section_id">Раздел:</label>
                    <select class="new-message__input" name="section_id" id="section_id">
                        <?php
                        renderSections($combinedSections, $incorrectData) ?>
                    </select>
                    <?= isset($errorMessage) ? "<p style=\"color: red; font-weight: bold;\">$errorMessage</p>" : null ?>
                    <button class="new-message__submit" type="submit">Отправить</button>
                </form>
            </td>
        </tr>
    </table>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
mysqli_close(connect());
