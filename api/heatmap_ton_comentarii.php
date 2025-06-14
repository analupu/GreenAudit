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

$comentarii = mysqli_query($con, "
    SELECT ac.id, ac.content, ac.article_id, a.title FROM articles_comments ac JOIN articles a ON a.id = ac.article_id ORDER BY ac.created_at DESC LIMIT 10");

$map = [];

while ($c = mysqli_fetch_assoc($comentarii)) {
    $ton = detecteazaTon($c['content']);
    $titlu = $c['title'];

    if (!isset($map[$titlu])) {
        $map[$titlu] = ['Pozitiv' => 0, 'Neutru' => 0, 'Negativ' => 0];
    }

    $map[$titlu][$ton]++;
}

$heatmapData = [];
$tonuri = ['Pozitiv', 'Neutru', 'Negativ'];

foreach ($map as $articol => $valori) {
    $serie = ['name' => $articol, 'data' => []];
    foreach ($tonuri as $t) {
        $serie['data'][] = ['x' => $t, 'y' => $valori[$t]];
    }
    $heatmapData[] = $serie;
}

echo json_encode($heatmapData);
