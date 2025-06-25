<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php';
?>
<nav class="navbar navbar-expand-md fixed-top navbar-light bg-light border border-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">
            <img src="/images/green_audit_logo_admin.png" height="50" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto mb-2 mb-md-0">
                <a class="btn btn-outline-secondary ms-4 me-4 <?= $_SERVER['PHP_SELF'] == '/index.php' ? 'active fw-bold' : '' ?>"
                   href="/index.php" <?= $_SERVER['PHP_SELF'] == '/index.php' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-calculator"></i> Calculator
                </a>
                <a class="btn btn-outline-secondary me-4 <?= $_SERVER['PHP_SELF'] == '/articole/index.php' || $_SERVER['PHP_SELF'] == '/articole/articol.php' ? 'active fw-bold' : '' ?>"
                   href="/articole" <?= $_SERVER['PHP_SELF'] == '/articole/index.php' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-newspaper"></i> Articole
                </a>
                <a class="btn btn-outline-secondary me-4 <?= $_SERVER['PHP_SELF'] == '/imagini/index.php' ? 'active fw-bold' : '' ?>"
                   href="/imagini" <?= $_SERVER['PHP_SELF'] == '/imagini/index.php' ? 'aria-current="page"' : '' ?>>
                    <i class="fa-solid fa-image"></i> Imagini
                </a>
            </div>
            <form class="d-flex" role="search">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <?php if (isset($is_logged) && $is_logged) { ?>
                        <?php
                        $logged_user = mysqli_fetch_assoc(mysqli_query($con, "SELECT id, is_admin FROM users WHERE id = " . $_SESSION['audit_admin_logged_in_user_id']));

                        if ($logged_user['is_admin'] == '1') {
                            echo '<a class="btn btn-outline-success me-4" href="/admin/index.php"><i class="fa-solid fa-crown"></i> Admin</a>';
                        }
                        ?>
                        <a class="btn btn-outline-primary me-4 <?= $_SERVER['PHP_SELF'] == '/my_account/index.php' || $_SERVER['PHP_SELF'] == '/my_account/history.php' || $_SERVER['PHP_SELF'] == '/my_account/settings.php'? 'active fw-bold' : '' ?>" href="/my_account/index.php"><i class="fa-solid fa-user"></i> Contul meu</a>
                        <a class="btn btn-outline-danger me-4" href="/my_account/index.php?logout"><i class="fa-solid fa-right-from-bracket"></i> Iesire</a>
                    <?php } else { ?>
                        <a class="btn btn-outline-primary me-4" href="/login.php"><i class="fa-solid fa-right-from-bracket"></i> Conectare</a>
                        <a class="btn btn-outline-success me-4" href="/register.php"><i class="fa-solid fa-user-plus"></i> Inregistrare</a>
                    <?php } ?>
                </ul>
            </form>
        </div>
    </div>
</nav>