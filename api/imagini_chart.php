<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

$query = "SELECT title, likes, dislikes FROM image_gallery";
$result = mysqli_query($con, $query);

$titluri = [];
$likes = [];
$dislikes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $titluri[] = $row['title'];
    $likes[] = (int)$row['likes'];
    $dislikes[] = (int)$row['dislikes'];
}

echo json_encode([
    'titluri' => $titluri,
    'likes' => $likes,
    'dislikes' => $dislikes
]);
