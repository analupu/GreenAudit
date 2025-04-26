<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';


    if (isset($_GET['save'])) {
        $contentHash = md5(json_encode($_GET['consumers']));
        mysqli_query($con, "INSERT INTO `results_history` (`user_id`, `content`, `content_hash`) VALUES ('" . $_SESSION['audit_logged_in_user_id'] . "', '" . json_encode($_GET['consumers']) . "', '" . $contentHash . "')");
        unset($_GET['save']);
        header('Location: /rezultat.php?' . http_build_query($_GET));
        die;
    }

    $alreadyExists = false;
    $contentHash = md5(json_encode($_GET['consumers']));
    $alreadyExistsQuery = mysqli_query($con, "SELECT `content_hash` FROM `results_history` WHERE `content_hash` = '" . $contentHash . "' AND `user_id` = '" . $_SESSION['audit_logged_in_user_id']   . "'");
    if (mysqli_num_rows($alreadyExistsQuery)) {
        $alreadyExists = true;
    }

    $settingsQuery = mysqli_query($con, "SELECT `settings` FROM `users` WHERE `id` = '" . $_SESSION['audit_logged_in_user_id'] . "'");
    $userSettings = mysqli_num_rows($settingsQuery) ? json_decode(mysqli_fetch_row($settingsQuery)[0], true) : false;

?>
<!doctype html>
<html lang="ro" data-bs-theme="auto">
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
    </head>
    <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
        <main class="container">
            <div class="bg-body-tertiary p-5 rounded row">
                <div class="col-10 offset-1">
                    <h1 class="h3 mb-3 fw-normal text-center">Consum zilnic (tarife e-on)</h1>
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

                                foreach ($_GET['consumers'] as $consumer) {
                                    $totalPower += (int)$consumer['power'] / 1000;
                                    $totalRunTime += (int)$consumer['runTime'];
                                    $totalCount += (int)$consumer['count'];

                                    $totalZilnic = ((int)$consumer['power'] / 1000) * (int)$consumer['runTime'] * (int)$consumer['count'];
                                    $grandTotalConsum += $totalZilnic;

                                    echo '<tr>';
                                    echo '<td>' . $i . '</td>';
                                    echo '<td>' . $consumer['brand'] . '</td>';
                                    echo '<td>' . $consumer['energyClass'] . '</td>';
                                    echo '<td>' . $consumer['name'] . '</td>';
                                    echo '<td>' . number_format((int)$consumer['power'] / 1000, 2) . '</td>';
                                    echo '<td>' . number_format((int)$consumer['runTime'], 2) . '</td>';
                                    echo '<td>' . number_format((int)$consumer['count'], 2) . '</td>';
                                    echo '<td>' . number_format($totalZilnic, 2) . ' kW</td>';
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

                <div class="col-10 offset-1 mt-5">
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

                            $costTotal = 0;

                            foreach ($_GET['consumers'] as $consumer) {
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
                <div class="col-10 offset-1 mt-5 text-center">
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
                            } else {
                                $consumTotalLunarLei = ((255 * 0.8) + (($grandTotalConsum - 255) * 1.3));
                                echo '<h2 class="mb-4">' . number_format($consumTotalLunarLei, 2) . ' Lei</h2>';
                                echo '<h5>0.00 - 255.00 Kw = 0.80 Lei/kW</h5>';
                                echo '<h5>256.00 - ' . number_format($grandTotalConsum, 2) . ' Kw = 1.3 Lei/kW</h5>';
                            }

                        ?>
                </div>
                <?php if (!empty($userSettings['venitLunar']) && !empty($userSettings['numarulMembrilor'])) { ?>
                    <div class="col-10 offset-1 mt-5 text-center">
                        <?php
                            $totalsArray = [];

                            $history_query = mysqli_query($con, "SELECT `id`, `content`, `content_hash`, `created_at` FROM `results_history`  WHERE `user_id` = " . $_SESSION['audit_logged_in_user_id'] . " ORDER BY `id` DESC");
                            if (mysqli_num_rows($history_query)) {
                                while ($historyRow = mysqli_fetch_assoc($history_query)) {
                                    $consumTotalLunarLei = 0;
                                    $totalPower = 0;
                                    $totalRunTime = 0;
                                    $totalCount = 0;

                                    foreach (json_decode($historyRow['content'], true) as $consumer) {

                                        $totalPower += (int)$consumer['power'] / 1000;
                                        $totalRunTime += (int)$consumer['runTime'] * 30;
                                        $totalCount += (int)$consumer['count'];

                                        $total = ((int)$consumer['power'] / 1000) * ((int)$consumer['runTime'] * 30) * (int)$consumer['count'];
                                        $totalsArray[] = $total;
                                    }
                                }

                                $totalsArray[] = $grandTotalConsum;


                                $totalsArray = array_reverse($totalsArray);
                                $copacei = 0;
                                foreach ($totalsArray as $i => $total) {
                                    if ($i > 0) {
                                        $dif = $totalsArray[$i-1] - $total;
                                        if ($dif > 0) {
                                            $copacei += $dif / 10;
                                        } else {
                                            $copacei -= abs($dif) / 10;
                                        }
                                    }
                                }

                                if ($copacei > 0) {
                                    echo '<h1>Copaci salvati</h1>';
                                    echo $copacei . ' copacei salvati prin reducerea consumului cu ' . $copacei * 10 . ' kW raportat la prima simulare.<br />(Este necesara salveaza simularii curente.)' ;
                                } else {
                                    echo '<h1>Copaci pierduti</h1>';
                                    echo abs($copacei) . ' copacei pierduti prin cresterea consumului cu ' . abs($copacei) * 10 . ' kW raportat la prima simulare';
                                }

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
                <div class="col-10 offset-1 mt-5 text-center">
                    <a href="/index.php?recalculeaza=true&<?php echo http_build_query($_GET) ?>" class="btn btn-primary py-2 w-25 mb-4"><i
                                class="fa-solid fa-calculator"></i> Recalculeaza
                    </a>
                    <br />
                <?php if (!$alreadyExists) { ?>
                    <a href="/rezultat.php?save=true&<?php echo http_build_query($_GET) ?>" class="btn btn-primary py-2 w-25"><i
                                class="fa-solid fa-save"></i> Salveaza rezultat
                    </a>
                <?php } else { ?>
                    <a href="/my_account/history.php?entry=<?php echo mysqli_fetch_row($alreadyExistsQuery)[0]; ?>" class="btn btn-primary py-2 w-25"><i
                                class="fa-solid fa-save"></i> Vezi in istoric
                    </a>
                <?php } ?>
                </div>
            </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
    </body>
</html>