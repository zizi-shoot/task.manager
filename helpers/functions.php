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



