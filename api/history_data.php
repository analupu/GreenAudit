<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    $queryConsumLunar = mysqli_query($con, "SELECT `content`, `created_at` FROM `results_history` WHERE `user_id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");

    $series = [];
    while ($row = mysqli_fetch_assoc($queryConsumLunar)) {
        $totalPower = 0;
        $totalRunTime = 0;
        $totalCount = 0;

        $grandTotalConsum = 0;

        foreach (json_decode($row['content'], true) as $consumer) {
            $totalPower += (int)$consumer['power'] / 1000;
            $totalRunTime += (int)$consumer['runTime'] * 30;
            $totalCount += (int)$consumer['count'];

            $total = ((int)$consumer['power'] / 1000) * ((int)$consumer['runTime'] * 30) * (int)$consumer['count'];
            $grandTotalConsum += $total;

            $monthlyRunTime = number_format((int)$consumer['runTime'] * 30, 2);
            $monthlyCount = number_format((int)$consumer['count'], 2);
            $monthlyConsum = number_format($total, 2);
        }

        $consumTotalLunarLei = 0;

        if ($grandTotalConsum <= 100) {
            $consumTotalLunarLei = $grandTotalConsum * 0.68;
        } elseif ($grandTotalConsum <= 255) {
            $consumTotalLunarLei = $grandTotalConsum * 0.80;
        } else {
            $consumTotalLunarLei = ((255 * 0.8) + (($grandTotalConsum - 255) * 1.3));
        }

        $series[0][] = [
            'x' => $row['created_at'],
            'y' => $consumTotalLunarLei,
        ];

        $series[1][] = [
            'x' => $row['created_at'],
            'y' => $grandTotalConsum,
        ];

        $series[2][] = [
            'x' => $row['created_at'],
            'y' => $totalRunTime,
        ];
    }


    echo json_encode($series);
?>