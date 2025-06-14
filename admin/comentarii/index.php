<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/check_login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';

    if (isset($_GET['deleteId'])) {
        $delete_id = $_GET['deleteId'];

        mysqli_query($con, "DELETE FROM articles_comments WHERE id=$delete_id");
        header('location: /admin/comentarii');
        die;
    }

    if (isset($_GET['article_filter']) && !empty($_GET['article_filter'])) {
        $comentarii = mysqli_query($con, "SELECT * FROM `articles_comments` WHERE `article_id` = '" . $_GET['article_filter'] . "' ORDER BY `created_at` DESC");
    } else {
        $comentarii = mysqli_query($con, "SELECT * FROM `articles_comments` ORDER BY `created_at` DESC");
    }
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
                <h2>Comentarii</h2>
                <div class="card text-bg-primary mb-3 mt-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Comentarii</h5>
                        <p class="card-text"><?php echo mysqli_num_rows($comentarii); ?></p>
                    </div>
                </div>
                <form method="get" action="/admin/comentarii/index.php">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="article_filter">Articol</label>
                        </div>
                        <div class="col-auto">
                            <select id="article_filter" class="form-select" name="article_filter">
                                <?php
                                    $articles = mysqli_query($con, "SELECT * FROM `articles` ORDER BY `created_at` DESC");

                                    while ($article = mysqli_fetch_assoc($articles)) {
                                        $selected = '';

                                        if (isset($_GET['article_filter']) && !empty($_GET['article_filter']) && $article['id'] == $_GET['article_filter']) {
                                            $selected = 'selected';
                                        }

                                        echo '<option value="' . $article['id'] . '" ' . $selected . '>' . $article['title'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filtreaza</button>
                        </div>
                        <?php if (isset($_GET['article_filter'])) { ?>
                            <div class="col-auto">
                                <a href="/admin/comentarii/index.php" class="btn btn-danger">Reseteaza</a>
                            </div>
                        <?php } ?>
                    </div>
                </form>

                <div class="d-flex justify-content-end mb-3">
                    <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-secondary border-secondary text-white"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control bg-dark text-white border-secondary" placeholder="Caută...">
                    </div>
                </div>

                <?php if (mysqli_num_rows($comentarii)) { ?>
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Autor</th>
                            <th>Titlu</th>
                            <th>Continut</th>
                            <th>Data</th>
                            <th>Ton</th>
                            <th>Actiune</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (mysqli_num_rows($comentarii)) {

                            // functie care detecteaza tonul utilizatorului dupa cuvinte cheie din comentariu
                            function detecteazaTon($text)
                            {
                                $pozitive = ['bine', 'frumos', 'excelent', 'superb', 'apreciez', 'mulțumesc', 'interesant', 'îmi place', 'util', 'foarte bun', 'clar', 'super'];
                                $negative = ['prost', 'rău', 'inutil', 'urât', 'slab', 'nu-mi place', 'dezamăgitor', 'greșit', 'deranjant', 'confuz'];

                                $text = mb_strtolower($text, 'UTF-8');
                                $scor = 0;

                                foreach ($pozitive as $cuvant) {
                                    if (strpos($text, $cuvant) !== false) {
                                        $scor += 1;
                                    }
                                }

                                foreach ($negative as $cuvant) {
                                    if (strpos($text, $cuvant) !== false) {
                                        $scor -= 1;
                                    }
                                }

                                if ($scor > 0) {
                                    return '<span class="badge bg-success">Pozitiv</span>';
                                } elseif ($scor < 0) {
                                    return '<span class="badge bg-danger">Negativ</span>';
                                } else {
                                    return '<span class="badge bg-secondary">Neutru</span>';
                                }
                            }

                            while ($comentariu = mysqli_fetch_assoc($comentarii)) {
                                echo '<tr class="align-middle">';
                                echo '<td>' . $comentariu['id'] . '</td>';
                                $autor = mysqli_fetch_assoc(mysqli_query($con, "SELECT `firstName`, `lastName` FROM `users` WHERE `id` = '" . $comentariu['user_id'] . "'"));
                                echo '<td>' . $autor['firstName'] . ' ' . $autor['lastName'] . '</td>';
                                $title = mysqli_fetch_assoc(mysqli_query($con, "SELECT `title` FROM `articles` WHERE `id` = '" . $comentariu['article_id'] . "'"));
                                echo '<td>' . $title['title'] . '</td>';
                                echo '<td>' . $comentariu['content'] . '</td>';
                                echo '<td>' . $comentariu['created_at'] . '</td>';
                                echo '<td>' . detecteazaTon($comentariu['content']) . '</td>';
                                echo '<td style="width: 225px;">
                                    <a class="btn btn-danger py-2 deleteComment" href="/admin/comentarii/index.php?deleteId=' . $comentariu['id'] . '"><i
                                    class="fa-solid fa-trash"></i> Sterge comentariu</a>
                            </td>';
                                echo '</tr>';
                            }
                        }
                         ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <h3 class="mt-3">Nu exista comentarii.</h3>
                <?php } ?>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-dark text-white p-2">
                    <div id="chart_ton_comentarii" style="height: 200px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-dark text-white p-2">
                    <div id="heatmap_ton_comentarii" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/inc/javascript.php'; ?>
<script src="/admin/assets/js/comentarii.js"></script>
</body>
</html>


