<?php
    require_once '../inc/check_login.php';
    require_once('../inc/config.php');

    $querySettingsHistory = mysqli_query($con, "SELECT `settings`, `created_at` FROM `settings_history` WHERE `user_id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");

    $series = [];
    while ($row = mysqli_fetch_assoc($querySettingsHistory)) {
        $settings = json_decode($row['settings'], true);

        $series[0][] = [
            'x' => isset($settings['updatedAt']) ? $settings['updatedAt'] : $row['created_at'],
            'y' => $settings['venitLunar'],
        ];

        $series[1][] = [
            'x' => isset($settings['updatedAt']) ? $settings['updatedAt'] : $row['created_at'],
            'y' => $settings['numarulMembrilor'],
        ];

        $series[2][] = [
            'x' => isset($settings['updatedAt']) ? $settings['updatedAt'] : $row['created_at'],
            'y' => (int)$settings['venitLunar'] / (int)$settings['numarulMembrilor'],
        ];
    }

    $currentSettings = mysqli_query($con, "SELECT `settings`, `created_at` FROM `users` WHERE `id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");

    while ($row = mysqli_fetch_assoc($currentSettings)) {
        $settings = json_decode($row['settings'], true);


        $series[0][] = [
            'x' => isset($settings['updatedAt']) ? $settings['updatedAt'] : $row['created_at'],
            'y' => $settings['venitLunar'],
        ];

        $series[1][] = [
            'x' => isset($settings['updatedAt']) ? $settings['updatedAt'] : $row['created_at'],
            'y' => $settings['numarulMembrilor'],
        ];

        $series[2][] = [
            'x' => isset($settings['updatedAt']) ? $settings['updatedAt'] : $row['created_at'],
            'y' => (int)$settings['venitLunar'] / (int)$settings['numarulMembrilor'],
        ];
    }


    echo json_encode($series);


?>