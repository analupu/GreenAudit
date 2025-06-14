<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        mysqli_query($con, "DELETE FROM results_history WHERE id=$delete_id");
        header('location: /my_account/history.php');
        die;
    }

    $settingsQuery = mysqli_query($con, "SELECT `settings` FROM `users` WHERE `id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");
    $userSettings = json_decode(mysqli_fetch_row($settingsQuery)[0], true);

    $settingsQuery = mysqli_query($con, "SELECT `settings` FROM `users` WHERE `id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");
    $userSettings = mysqli_num_rows($settingsQuery) ? json_decode(mysqli_fetch_row($settingsQuery)[0], true) : false;
?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
        <link href="/assets/css/page_ed.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
        <main class="d-flex">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
                <h2 class="fs-4">Contul meu</h2>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/my_account/index.php" class="nav-link text-white" aria-current="page"><i class="fa-solid fa-list"></i>
                            Rezumat
                        </a>
                    </li>
                    <li>
                        <a href="/my_account/history.php" class="nav-link active text-white"><i class="fa-solid fa-clock-rotate-left"></i>
                            Istoric
                        </a>
                    </li><li>
                        <a href="/my_account/settings.php" class="nav-link text-white"><i class="fa-solid fa-gear"></i>
                            Setari
                        </a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <?php
                    $history_query = mysqli_query($con, "SELECT `id`, `content`, `content_hash`, `created_at` FROM `results_history`  WHERE `user_id` = " . $_SESSION['audit_logged_in_user_id'] . " ORDER BY id DESC");

                    if (mysqli_num_rows($history_query)) {
                        $historyRows = mysqli_fetch_all($history_query, MYSQLI_ASSOC);

                        foreach ($historyRows as $ia => $historyRow) { ?>
                            <div class="accordion" id="accordionExample<?php echo $ia ?>">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse<?php echo $ia ?>" aria-expanded="true"
                                                aria-controls="collapse<?php echo $ia ?>">
                                            <?php echo $historyRow['created_at'] ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $ia ?>" class="accordion-collapse collapse <?php if (isset($_GET['entry']) && $_GET['entry'] == $historyRow['content_hash']) { echo 'show'; } ?>"
                                         data-bs-parent="#accordionExample<?php echo $ia ?>">
                                        <div class="accordion-body">
                                            <div class="col-8 offset-2">
                                                <h1 class="h3 mb-3 fw-normal text-center">Consum zilnic (tarife e-on)</h1>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Numar</th>
                                                            <th scope="col">Marca</th>
                                                            <th scope="col">Clasa energetica</th>
                                                            <th scope="col">Denumire</th>
                                                            <th scope="col">Consum (kW)</th>
                                                            <th scope="col">Ore</th>
                                                            <th scope="col">Cantitate</th>
                                                            <th scope="col">Total aparat (kW)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 1;

                                                            $totalPower = 0;
                                                            $totalRunTime = 0;
                                                            $totalCount = 0;

                                                            $grandTotal = 0;

                                                            foreach (json_decode($historyRow['content'], true) as $consumer) {
                                                                $totalPower += (int)$consumer['power'] / 1000;
                                                                $totalRunTime += (int)$consumer['runTime'];
                                                                $totalCount += (int)$consumer['count'];

                                                                $grandTotal += ((int)$consumer['power'] / 1000) * (int)$consumer['runTime'] * (int)$consumer['count'];

                                                                echo '<tr>';
                                                                echo '<td>' . $i . '</td>';
                                                                echo '<td>' . $consumer['brand'] . '</td>';
                                                                echo '<td>' . $consumer['energyClass'] . '</td>';
                                                                echo '<td>' . $consumer['name'] . '</td>';
                                                                echo '<td>' . number_format((int)$consumer['power'] / 1000, 2) . '</td>';
                                                                echo '<td>' . number_format((int)$consumer['runTime'], 2) . '</td>';
                                                                echo '<td>' . number_format((int)$consumer['count'], 2) . '</td>';
                                                                echo '<td>' . number_format(((int)$consumer['power'] / 1000) * (int)$consumer['runTime'] * (int)$consumer['count'], 2) . ' kW</td>';

                                                                echo '</tr>';
                                                                $i++;
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">Total</td>
                                                            <td><?php echo number_format($totalPower, 2); ?></td>
                                                            <td><?php echo number_format($totalRunTime, 2); ?></td>
                                                            <td><?php echo number_format($totalCount, 2); ?></td>
                                                            <td><?php echo number_format($grandTotal, 2) . " kW"; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-8 offset-2 mt-5">
                                                <h1 class="h3 mb-3 fw-normal text-center">Consum lunar (tarife e-on)</h1>
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Numar</th>
                                                        <th scope="col">Marca</th>
                                                        <th scope="col">Clasa energetica</th>
                                                        <th scope="col">Tip</th>
                                                        <th scope="col">Consum (kW)</th>
                                                        <th scope="col">Ore</th>
                                                        <th scope="col">Cantitate</th>
                                                        <th scope="col">Total aparat (kW)</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $i = 1;

                                                    $totalPower = 0;
                                                    $totalRunTime = 0;
                                                    $totalCount = 0;

                                                    $grandTotalConsum = 0;

                                                    foreach (json_decode($historyRow['content'], true) as $consumer) {
                                                        $totalPower += (int)$consumer['power'] / 1000;
                                                        $totalRunTime += (int)$consumer['runTime'] * 30;
                                                        $totalCount += (int)$consumer['count'];

                                                        $total = ((int)$consumer['power'] / 1000) * ((int)$consumer['runTime'] * 30) * (int)$consumer['count'];
                                                        $grandTotalConsum += $total;

                                                        echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $consumer['brand'] . '</td>';
                                                        echo '<td>' . $consumer['energyClass'] . '</td>';
                                                        echo '<td>' . $consumer['name'] . '</td>';
                                                        echo '<td>' . number_format(((int)$consumer['power'] / 1000), 2) . '</td>';
                                                        echo '<td>' . number_format((int)$consumer['runTime'] * 30, 2) . '</td>';
                                                        echo '<td>' . number_format((int)$consumer['count'], 2) . '</td>';
                                                        echo '<td>' . number_format($total, 2) . ' kW</td>';
                                                        echo '</tr>';
                                                        $i++;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4">Total</td>
                                                        <td><?php echo number_format($totalPower, 2); ?></td>
                                                        <td><?php echo number_format($totalRunTime, 2); ?></td>
                                                        <td><?php echo number_format($totalCount, 2); ?></td>
                                                        <td><?php echo number_format($grandTotalConsum, 2) . " kW"; ?>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-8 offset-2 mt-5 text-center">
                                                <h1 class="h3 mb-3 fw-normal">Consum total lunar</h1>
                                                <?php
                                                echo "<h2>" . number_format($grandTotalConsum, 2) . " kW</h2>";

                                                $consumTotalLunarLei = 0;
                                                if ($grandTotalConsum <= 100) {
                                                    $consumTotalLunarLei = $grandTotalConsum * 0.68;
                                                    echo '<h2 class="mb-4">' . number_format($consumTotalLunarLei, 2) . ' Lei</h2>';
                                                    echo '<h5>0.00 - ' . number_format($grandTotalConsum, 2) .  ' Kw = 0.68 Lei/kW</h5>';
                                                } elseif ($grandTotalConsum <= 255) {
                                                    $consumTotalLunarLei = $grandTotalConsum * 0.80;
                                                    echo '<h2 class="mb-4">' . number_format($consumTotalLunarLei, 2) . ' Lei</h2>';
                                                    echo '<h5>0.00 - ' . number_format($grandTotalConsum, 2) . ' Kw = 0.80 Lei/kW</h5>';
                                                } elseif ($grandTotalConsum <= 300) {
                                                    $consumTotalLunarLei = ((255 * 0.8) + (($grandTotalConsum - 255) * 1.3));
                                                    echo '<h2 class="mb-4">' . number_format($consumTotalLunarLei, 2) . ' Lei</h2>';
                                                    echo '<h5>0.00 - 255.00 Kw = 0.80 Lei/kW</h5>';
                                                    echo '<h5>255.01 - ' . number_format($grandTotalConsum, 2) . ' Kw = 1.3 Lei/kW</h5>';
                                                } else {
                                                    $consumTotalLunarLei = $grandTotalConsum * 1.30;
                                                    echo '<h2 class="mb-4">' . number_format($consumTotalLunarLei, 2) . ' Lei</h2>';
                                                    echo '<h5>0.00 - ' . number_format($grandTotalConsum, 2) . ' kWh = 1.30 Lei/kWh</h5>';
                                                }
                                                ?>
                                            </div>
                                            <?php if (!empty($userSettings['venitLunar']) && !empty($userSettings['numarulMembrilor'])) { ?>
                                                <div class="col-8 offset-2 mt-5 text-center">
                                                    <?php
                                                        if ($ia < (count($historyRows) - 1)) {
                                                            $copacei = 0;

                                                            $nextHistoryEntry = $historyRows[$ia + 1];

                                                            $nextGrandTotalConsum = 0;
                                                            foreach (json_decode($nextHistoryEntry['content'], true) as $nextHistoryConsumer) {
                                                                $totalPower += (int)$nextHistoryConsumer['power'] / 1000;
                                                                $totalRunTime += (int)$nextHistoryConsumer['runTime'] * 30;
                                                                $totalCount += (int)$nextHistoryConsumer['count'];

                                                                $total = ((int)$nextHistoryConsumer['power'] / 1000) * ((int)$nextHistoryConsumer['runTime'] * 30) * (int)$nextHistoryConsumer['count'];
                                                                $nextGrandTotalConsum += $total;
                                                            }

//                                                            $totalsArray = [];
//                                                            foreach ($historyRows as $i2 => $historyRow2) {
//                                                                if ($i2 >= $ia) {
//                                                                    foreach (json_decode($historyRow2['content'], true) as $historyRow2Conten) {
//                                                                        $totalPower += (int)$historyRow2Conten['power'] / 1000;
//                                                                        $totalRunTime += (int)$historyRow2Conten['runTime'] * 30;
//                                                                        $totalCount += (int)$historyRow2Conten['count'];
//
//                                                                        $total = ((int)$historyRow2Conten['power'] / 1000) * ((int)$historyRow2Conten['runTime'] * 30) * (int)$historyRow2Conten['count'];
//                                                                        $totalsArray[] = $total;
//                                                                    }
//                                                                }
//                                                            }
//
//                                                            $totalsArray = array_reverse($totalsArray);
//                                                            $copacei2 = 0;
//                                                            foreach ($totalsArray as $i => $total) {
//                                                                if ($i > 0) {
//                                                                    $dif2 = $totalsArray[$i-1] - $total;
//                                                                    if ($dif2 > 0) {
//                                                                        $copacei2 += $dif2 / 10;
//                                                                    } else {
//                                                                        $copacei2 -= abs($dif2) / 10;
//                                                                    }
//                                                                }
//                                                            }

                                                            $firstSimulationQuery = mysqli_query($con, "SELECT `content` FROM `results_history` WHERE `user_id` = " . $_SESSION['audit_logged_in_user_id'] . " ORDER BY `id` ASC LIMIT 1");

                                                            if (mysqli_num_rows($firstSimulationQuery)) {
                                                                $firstSimulation = mysqli_fetch_assoc($firstSimulationQuery);
                                                                $firstTotal = 0;

                                                                foreach (json_decode($firstSimulation['content'], true) as $consumer) {
                                                                    $firstTotal += ((int)$consumer['power'] / 1000) * ((int)$consumer['runTime'] * 30) * (int)$consumer['count'];
                                                                }

                                                                $difference = $firstTotal - $grandTotalConsum;
                                                                $copacei2 = $difference / 10;

                                                                if ($copacei2 > 0) {
                                                                    echo '<h1>Copaci salvati fata de prima simulare</h1>';
                                                                    echo number_format($copacei2, 1) . ' copacei salvati prin reducerea consumului cu ' . number_format(abs($difference), 1) . ' kW.';
                                                                } else {
                                                                    echo '<h1>Copaci pierduti fata de prima simulare</h1>';
                                                                    echo number_format(abs($copacei2), 1) . ' copacei pierduti prin cresterea consumului cu ' . number_format(abs($difference), 1) . ' kW.';
                                                                }
                                                            }

                                                            $dif = $nextGrandTotalConsum - $grandTotalConsum;
                                                            if ($dif > 0) {
                                                                $copacei += $dif / 10;
                                                            } else {
                                                                $copacei -= abs($dif) / 10;
                                                            }

                                                            if ($copacei > 0) {
                                                                echo '<h1>Copaci salvati fata de simularea precedenta</h1>';
                                                                echo $copacei . ' copacei salvati prin reducerea consumului cu ' . $copacei * 10 . ' kW.';
                                                            } else {
                                                                echo '<h1>Copaci pierduti fata de simularea precedenta</h1>';
                                                                echo abs($copacei) . ' copacei pierduti prin cresterea consumului cu ' . abs($copacei) * 10 . ' kW.';
                                                            }

//                                                            if ($copacei2 > 0) {
//                                                                echo '<h1>Copaci salvati fata de prima simulare</h1>';
//                                                                echo $copacei2 . ' copacei salvati prin reducerea consumului cu ' . $copacei2 * 10 . ' kW.';
//                                                            } else {
//                                                                echo '<h1>Copaci pierduti fata de prima simulare</h1>';
//                                                                echo abs($copacei2) . ' copacei pierduti prin cresterea consumului cu ' . abs($copacei2) * 10 . ' kW.';
//                                                            }
                                                        }
                                                    ?>
                                                    <h1 class="h3 mb-3 fw-normal">Status</h1>
                                                    <?php
                                                    $procentConsumPersoana =  ($consumTotalLunarLei  * 100) / ((int)$userSettings['venitLunar'] / (int)$userSettings['numarulMembrilor']);

                                                    if ($procentConsumPersoana <= 5) {
                                                        echo '<div class="alert alert-success my-4" role="alert">Consum optim!</div>';
                                                    } elseif ($procentConsumPersoana <= 15) {
                                                        echo '<div class="alert alert-warning my-4" role="alert">Consum moderat!</div>';
                                                        echo '<h1 class="h3 mb-3 fw-normal">Recomandari:</h1>';
                                                        echo '<ul class="list-group">';
                                                        echo '<li class="list-group-item">Panouri fotofoltaice</li>';
                                                        echo '<li class="list-group-item">Prize inteligente multiple</li>';
                                                        echo '<li class="list-group-item">Termostat</li>';
                                                        echo '<li class="list-group-item">Monitorizare live a consumului prin senzori inteligenti.</li>';
                                                        echo '</ul>';
                                                    } else {
                                                        echo '<div class="alert alert-danger my-4" role="alert">Risipa energetica!</div>';
                                                        echo '<h1 class="h3 mb-3 fw-normal">Recomandari:</h1>';
                                                        if ($userSettings['venitLunar'] <= 3000) {
                                                            echo '<ul class="list-group">';
                                                            echo '<li class="list-group-item">Redu numarul de ore de funcionare.</li>';
                                                            echo '<li class="list-group-item">Inlocuirea cu produse second-hamd mai eficiente.</li>';
                                                            echo '</ul>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            <?php } ?>
                                            <div class="col-8 offset-2 mt-5 text-center">
                                                <a href="/index.php?recalculeaza=true&<?php echo http_build_query(['consumers' => json_decode($historyRow['content'], true)]); ?>" class="btn btn-primary py-2 mb-4"><i
                                                            class="fa-solid fa-calculator"></i> Recalculeaza
                                                </a>
                                                <br />
                                                <a href="/my_account/history.php?delete_id=<?php echo $historyRow['id']; ?>" class="btn btn-danger py-2 deleteHistoryRecord"><i
                                                            class="fa-solid fa-trash"></i> Sterge
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $ia++;
                        } ?>
                    <?php } else { ?>
                        Nu exista date!
                <?php } ?>
            </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
        <script src="../assets/js/history.js"></script>
    </body>
</html>
