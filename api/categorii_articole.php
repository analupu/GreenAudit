<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

$query = " SELECT ac.name AS categorie, COUNT(a.id) AS numar FROM articles_categories ac LEFT JOIN articles a ON a.category_id = ac.id GROUP BY ac.name";

$result = mysqli_query($con, $query);

$categorii = [];
$valori = [];

while ($row = mysqli_fetch_assoc($result)) {
    $categorii[] = $row['categorie'];
    $valori[] = (int)$row['numar'];
}

echo json_encode([
    'categorii' => $categorii,
    'valori' => $valori,
]);
