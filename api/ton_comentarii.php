<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

function detecteazaTon($text) {
    $pozitive = ['bine', 'frumos', 'excelent', 'superb', 'apreciez', 'mulțumesc', 'interesant', 'îmi place', 'util', 'foarte bun', 'clar', 'super'];
    $negative = ['prost', 'rău', 'inutil', 'urât', 'slab', 'nu-mi place', 'dezamăgitor', 'greșit', 'deranjant', 'confuz'];

    $text = mb_strtolower($text, 'UTF-8');
    $scor = 0;

    foreach ($pozitive as $cuvant) {
        if (strpos($text, $cuvant) !== false) $scor++;
    }

    foreach ($negative as $cuvant) {
        if (strpos($text, $cuvant) !== false) $scor--;
    }

    if ($scor > 0) return 'Pozitiv';
    if ($scor < 0) return 'Negativ';
    return 'Neutru';
}

$result = mysqli_query($con, "SELECT `content` FROM `articles_comments`");

$distributie = ['Pozitiv' => 0, 'Neutru' => 0, 'Negativ' => 0];

while ($row = mysqli_fetch_assoc($result)) {
    $ton = detecteazaTon($row['content']);
    $distributie[$ton]++;
}

echo json_encode([
    'labels' => array_keys($distributie),
    'series' => array_values($distributie)
]);
