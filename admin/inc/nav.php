<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">Audit energetic</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">

                    <a class="nav-link <?= $_SERVER['PHP_SELF'] == '/index.php' ? 'active fw-bold' : '' ?>"
                       href="/index.php" <?= $_SERVER['PHP_SELF'] == '/index.php' ? 'aria-current="page"' : '' ?>>
                        Home
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $_SERVER['PHP_SELF'] == '/page_ed.php' ? 'active fw-bold' : '' ?>"
                       href="/page_ed.php" <?= $_SERVER['PHP_SELF'] == '/page_ed.php' ? 'aria-current="page"' : '' ?>>
                        Pagina educativa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $_SERVER['PHP_SELF'] == '/articole/index.php' ? 'active fw-bold' : '' ?>"
                       href="/articole" <?= $_SERVER['PHP_SELF'] == '/articole/index.php' ? 'aria-current="page"' : '' ?>>
                        Articole
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $_SERVER['PHP_SELF'] == '/grafice/index.php' ? 'active fw-bold' : '' ?>"
                       href="/grafice" <?= $_SERVER['PHP_SELF'] == '/grafice/index.php' ? 'aria-current="page"' : '' ?>>
                        Grafice
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $_SERVER['PHP_SELF'] == '/imagini/index.php' ? 'active fw-bold' : '' ?>"
                       href="/imagini" <?= $_SERVER['PHP_SELF'] == '/imagini/index.php' ? 'aria-current="page"' : '' ?>>
                        Imagini
                    </a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <?php if (isset($is_logged)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $_SERVER['PHP_SELF'] == '/admin/index.php' || $_SERVER['PHP_SELF'] == '/admin/utilizatori/index.php' || $_SERVER['PHP_SELF'] == '/admin/articole/index.php' || $_SERVER['PHP_SELF'] == '/admin/comentarii/index.php' || $_SERVER['PHP_SELF'] == '/admin/categorii_articole/index.php' ? 'active fw-bold' : '' ?>" href="/admin/index.php">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/index.php?logout">Iesire</a>
                        </li>
                    <?php } ?>
                </ul>
            </form>
        </div>
    </div>
</nav>