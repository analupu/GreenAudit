<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

if (isset($_GET['deleteId'])) {
    $delete_id = $_GET['deleteId'];

    mysqli_query($con, "DELETE FROM users WHERE id=$delete_id");
    header('location: /admin/utilizatori');
    die;
}

if (isset($_GET['blockId'])) {
    $block_id = $_GET['blockId'];

    $utlizator = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = $block_id");
    $utlizator = mysqli_fetch_assoc($utlizator);

    $blockStatus = 0;
    if ($utlizator['is_blocked'] == 1) {
        $blockStatus = 0;
    } else {
        $blockStatus = 1;
    }

    mysqli_query($con, "UPDATE users SET `is_blocked` = $blockStatus WHERE id=$block_id");
    header('location: /admin/utilizatori');
    die;
}



    $utlizatori = mysqli_query($con, "SELECT * FROM `users` WHERE `is_admin` = 0 ORDER BY `created_at` DESC");
    $utlizatori_blocati = mysqli_query($con, "SELECT * FROM `users` WHERE `is_admin` = 0 && `is_blocked` = 1 ORDER BY `created_at` DESC");


?>

<!doctype html>
<html lang="ro" data-bs-theme="auto">
<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/head.php'; ?>
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/nav.php'; ?>
<main class="d-flex">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/side_nav.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Utilizatori</h2>
                <div class="row">
                    <div class="card text-bg-primary me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Utilizatori</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($utlizatori); ?></p>
                        </div>
                    </div>
                    <div class="card text-bg-warning me-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Utilizatori blocati</h5>
                            <p class="card-text"><?php echo mysqli_num_rows($utlizatori_blocati); ?></p>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary float-end" href="/admin/utilizatori/creare_editare.php"><i
                            class="fa-solid fa-add"></i> Adauga</a>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prenume - Nume</th>
                        <th>Email</th>
                        <th>Proprietati</th>
                        <th>Actiune</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($utilizator = mysqli_fetch_assoc($utlizatori)) {
                        echo '<tr class="align-middle">';
                        echo '<td>' . $utilizator['id'] . '</td>';
                        echo '<td>' . $utilizator['firstName'] . ' ' . $utilizator['lastName'] . '</td>';
                        echo '<td>' . $utilizator['email'] . '</td>';
                        echo '<td>
                            Venit lunar: ' . json_decode($utilizator['settings'])->venitLunar . '<br />
                            Numarul membrilor: ' . json_decode($utilizator['settings'])->numarulMembrilor . '<br />
                            Tip locuinta: ' . json_decode($utilizator['settings'])->tipLocuinta . '
                        </td>';
                        echo '<td style="width: 380px;">
                                <a class="btn btn-primary me-3" href="/admin/utilizatori/creare_editare.php?editId=' . $utilizator['id'] . '"><i
                        class="fa-solid fa-pen"></i> Editare</a>
                        <a class="btn '; if ( $utilizator['is_blocked'] == '1' ) { echo 'btn-success';} else { echo 'btn-warning'; } echo ' me-3 blockUser" href="/admin/utilizatori/index.php?blockId=' . $utilizator['id'] . '"><i
                        class="fa-solid fa-lock"></i> ';  if ( $utilizator['is_blocked'] == '1' ) {echo 'Deblocheaza';} else { echo 'Blocheaza'; } echo '</a>
                                <a class="btn btn-danger py-2 deleteUser" href="/admin/utilizatori/index.php?deleteId=' . $utilizator['id'] . '"><i
                        class="fa-solid fa-trash"></i> Sterge</a>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
</body>
</html>


