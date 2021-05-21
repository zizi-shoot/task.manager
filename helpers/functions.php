<?php

declare(strict_types=1);

function arraySort(array $array, int $sort = SORT_ASC, string $key = 'sort'): array
{
    $indexArr = array_column($array, $key);
    array_multisort($indexArr, $sort, $array);

    return $array;
}

function cutString(string $str, int $length = 15, string $appends = '...'): string
{
    $str = trim($str);
    if (mb_strlen($str) <= $length) {
        return $str;
    }

    return mb_substr(trim($str), 0, $length - 3) . $appends;
}

function showMenu(array $array, string $placement): void
{
    $array = $placement === 'footer' ? arraySort($array, SORT_DESC, 'title') : arraySort($array);
    foreach ($array as $item) {
        $activeClass = $item['path'] === $_SERVER['REQUEST_URI'] ? 'active' : null;
        $title = cutString($item['title']);
        echo "<li><a class='$activeClass' href='{$item['path']}'>$title</a></li>";
    }
}

function clean(string $value): string
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);

    return htmlspecialchars($value);
}

function connect(): object
{
    static $connection = null;
    if ($connection === null) {
        $host = 'task.manager';
        $user = 'root';
        $pass = 'root';
        $dbname = 'task_manager';
        $connection = mysqli_connect($host, $user, $pass, $dbname) or die('Connection Error');
    }

    return $connection;
}

function getPass(string $login): string
{
    $value = mysqli_real_escape_string(connect(), clean($login));
    $sql = "SELECT u.passwords FROM users u WHERE u.e_mail = '$value'";
    $result = mysqli_query(connect(), $sql);
    $pass = mysqli_fetch_assoc($result);

    return $pass['passwords'] ?? '';
}

function getUserData(string $login): array
{
    $value = mysqli_real_escape_string(connect(), clean($login));
    $sql = "SELECT u.id, u.full_name, u.e_mail, u.phone, u.agreement, u.state, g.name group_name, g.description group_description
            FROM users u
                     LEFT JOIN group_user gu ON u.id = gu.user_id
                     LEFT JOIN `groups` g ON g.id = gu.group_id
            WHERE u.e_mail = '$value'";
    $result = mysqli_query(connect(), $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getUserMessages(string $login): array
{
    $value = mysqli_real_escape_string(connect(), clean($login));
    $sql = "SELECT m.id,
                   m.subject,
                   m.body,
                   m.sent_time,
                   m.read_state,
                   ua.full_name AS author,
                   ua.e_mail    AS author_mail,
                   ur.full_name AS recipient,
                   msp.name     AS parent_section,
                   msp.color    AS parent_color,
                   ms.name      AS section,
                   ms.color
            FROM messages m
                     LEFT JOIN users ua ON ua.id = m.author_id
                     LEFT JOIN users ur ON ur.id = m.recipient_id
                     LEFT JOIN message_sections ms ON ms.id = m.message_section_id
                     LEFT JOIN message_sections msp ON msp.id = ms.parent_id
            WHERE ur.e_mail = '$value'";
    $result = mysqli_query(connect(), $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getSections(): array
{
    $sql = "SELECT * FROM message_sections";
    $result = mysqli_query(connect(), $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getRecipients(): array
{
    $sql = "SELECT u.id, u.full_name
            FROM users u
                     LEFT JOIN group_user gu ON u.id = gu.user_id
            WHERE gu.group_id = 2";
    $result = mysqli_query(connect(), $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function renderMessages(array $values, string $readState): void
{
    foreach ($values as $value) {
        if ($value['read_state'] === $readState) {
            $parentLabel = $value['parent_section']
                ? "<span style=\"background: ${value['parent_color']};\">${value['parent_section']}</span>"
                : null;
            $label = "<span style=\"background: ${value['color']};\">${value['section']}</span>";
            echo "<li class='messages__item'>$parentLabel $label <a target='_blank' rel='noopener' href='item?id=${value['id']}'>${value['subject']}</a></li>";
        }
    }
}

function renderSections(array $sections, $incorrectData): void
{
    foreach ($sections as $item) {
        $selectedState = null;

        if (isset($incorrectData) && $item['id'] === $incorrectData['section_id']) {
            $selectedState = 'selected';
        }

        if (!isset($item['parent_id'])) {
            echo "<option $selectedState value='${item['id']}'>${item['name']}</option>";
            renderSections($item['child_sections'], $incorrectData);
        } else {
            echo "<option $selectedState value='${item['id']}'>&nbsp;&nbsp;&nbsp;${item['name']}</option>";
        }
    }
}

function insertMessage(array $data, string $id): ?string
{
    $data = array_map(fn($item) => validate($item), $data);

    if (array_search(null, $data)) {
        return 'Необходимо заполнить все поля';
    }

    $sql = "INSERT INTO messages (subject, body, author_id, recipient_id, message_section_id)
            VALUES ('${data['subject']}', '${data['body']}', '$id', '${data['recipient_id']}', '${data['section_id']}')";

    if (!mysqli_query(connect(), $sql)) {
        return mysqli_error(connect());
    }

    return null;
}

function validate(string $value): ?string
{
    $value = clean($value);
    if (empty($value)) {
        return null;
    }

    return mysqli_real_escape_string(connect(), $value);
}





