<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

$query = "
    SELECT YEAR(created_at) AS an, WEEK(created_at, 1) AS saptamana, MIN(DATE(created_at)) AS start_date, MAX(DATE(created_at)) AS end_date, COUNT(*) AS total
        FROM results_history GROUP BY an, saptamana ORDER BY an DESC, saptamana DESC";

$result = mysqli_query($con, $query);

$saptamani = [];
$valori = [];

while ($row = mysqli_fetch_assoc($result)) {
    $start = date("d M", strtotime($row['start_date']));
    $end = date("d M", strtotime($row['end_date']));
    $label = 'Săpt ' . $start . ' - ' . $end;

    $saptamani[] = $label;
    $valori[] = (int)$row['total'];
}

echo json_encode([
    'saptamani' => array_reverse($saptamani),
    'valori' => array_reverse($valori)
]);
