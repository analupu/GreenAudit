<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

$usersSettings = mysqli_query($con, "SELECT `settings` FROM `users`");

$locuinte = [];
while ($userSettomg = mysqli_fetch_assoc($usersSettings)) {
    $tipLocuienta = json_decode($userSettomg['settings'])->tipLocuinta;;

    if (!isset($locuinte[$tipLocuienta])) {
        $locuinte[$tipLocuienta] = 1;
    } else {
        $locuinte[$tipLocuienta]++;
    }
}

echo json_encode([
    'numeLocuinte' => array_keys($locuinte),
    'numarLocuinte' => array_values($locuinte),
]);
?>