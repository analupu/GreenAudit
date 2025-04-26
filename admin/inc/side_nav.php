<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
    <h2>Contul meu</h2>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/admin" class="nav-link text-white <?= $_SERVER['PHP_SELF'] == '/admin/index.php' ? 'active fw-bold' : '' ?>" aria-current="page"><i class="fa-solid fa-list"></i>
                Rezumat
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/utilizatori" class="nav-link text-white <?= $_SERVER['PHP_SELF'] == '/admin/utilizatori/index.php' || $_SERVER['PHP_SELF'] == '/admin/utilizatori/creare_editare.php' ? 'active fw-bold' : '' ?>" aria-current="page"><i class="fa-solid fa-user"></i>
                Utilizatori
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/categorii_articole" class="nav-link text-white <?= $_SERVER['PHP_SELF'] == '/admin/categorii_articole/index.php' || $_SERVER['PHP_SELF'] == '/admin/categorii_articole/creare_editare.php' ? 'active fw-bold' : '' ?>" aria-current="page"><i class="fa-solid fa-list"></i>
                Categorii articole
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/articole" class="nav-link text-white <?= $_SERVER['PHP_SELF'] == '/admin/articole/index.php' || $_SERVER['PHP_SELF'] == '/admin/articole/creare_editare.php' ? 'active fw-bold' : '' ?>" aria-current="page"><i class="fa-solid fa-list"></i>
                Articole
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/comentarii" class="nav-link text-white <?= $_SERVER['PHP_SELF'] == '/admin/comentarii/index.php' ? 'active fw-bold' : '' ?>" aria-current="page"><i class="fa-solid fa-list"></i>
                Comentarii
            </a>
        </li>
    </ul>
</div>