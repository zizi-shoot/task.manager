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
    mysqli_close(connect());

    return $pass['passwords'] ?? '';
}

function getUserData(string $login): array
{
    $value = mysqli_real_escape_string(connect(), clean($login));
    $sql = "SELECT u.full_name, u.e_mail, u.phone, u.agreement, u.state, g.name group_name, g.description group_description
            FROM users u
                     LEFT JOIN group_user gu ON u.id = gu.user_id
                     LEFT JOIN `groups` g ON g.id = gu.group_id
            WHERE u.e_mail = '$value'";
    $result = mysqli_query(connect(), $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close(connect());

    return $data;
}

function getUserMessages(string $login): array
{
    $value = mysqli_real_escape_string(connect(), clean($login));
    $sql = "SELECT m.id,
                   m.title,
                   m.subject,
                   m.sent_time,
                   m.read,
                   ua.full_name AS author,
                   ur.full_name AS recipient,
                   msp.name AS parent_section,
                   msp.color AS parent_color, 
                   ms.name AS section,
                   ms.color
            FROM messages m
                     LEFT JOIN users ua ON ua.id = m.author_id
                     LEFT JOIN users ur ON ur.id = m.recipient_id
                     LEFT JOIN message_sections ms ON ms.id = m.message_section_id
                     LEFT JOIN message_sections msp ON msp.id = ms.parent_id
            WHERE ur.id = '3'";
    $result = mysqli_query(connect(), $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $data;
}

function renderMessages(array $values, string $readState): void
{
    foreach ($values as $value) {
        if ($value['read'] === $readState) {
            $parentLabel = $value['parent_section']
                ? "<span style=\"background: ${value['parent_color']};\">${value['parent_section']}</span>"
                : null;
            $label = "<span style=\"background: ${value['color']};\">${value['section']}</span>";
            echo "<li class='messages__item'>${parentLabel} ${label} <a href='item_${value['id']}'>${value['title']}</a></li>";
        }
    }
}


