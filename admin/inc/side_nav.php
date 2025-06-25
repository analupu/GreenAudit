<div class="card" style="width: 280px; height: 85vh; margin-left: 0.75rem;">
    <div class="card-body">
        <div style="width: 100%;">
    <h2>Admin</h2>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/admin" class="nav-link text-dark <?= $_SERVER['PHP_SELF'] == '/admin/index.php' ? 'active text-white' : '' ?>" aria-current="page"><i class="fa-regular fa-bookmark"></i>
                Rezumat
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/utilizatori" class="nav-link text-dark <?= $_SERVER['PHP_SELF'] == '/admin/utilizatori/index.php' || $_SERVER['PHP_SELF'] == '/admin/utilizatori/creare_editare.php' ? 'active text-white' : '' ?>" aria-current="page"><i class="fa-solid fa-user"></i>
                Utilizatori
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/categorii_articole" class="nav-link text-dark <?= $_SERVER['PHP_SELF'] == '/admin/categorii_articole/index.php' || $_SERVER['PHP_SELF'] == '/admin/categorii_articole/creare_editare.php' ? 'active text-white' : '' ?>" aria-current="page"><i class="fa-solid fa-list"></i>
                Categorii articole
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/articole" class="nav-link text-dark <?= $_SERVER['PHP_SELF'] == '/admin/articole/index.php' || $_SERVER['PHP_SELF'] == '/admin/articole/creare_editare.php' ? 'active text-white' : '' ?>" aria-current="page"><i class="fa-solid fa-newspaper"></i>
                Articole
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/comentarii" class="nav-link text-dark <?= $_SERVER['PHP_SELF'] == '/admin/comentarii/index.php' ? 'active text-white' : '' ?>" aria-current="page"><i class="fa fa-comment" aria-hidden="true"></i>
                Comentarii
            </a>
        </li>
        <li class="nav-item">
            <a href="/admin/imagini" class="nav-link text-dark <?= $_SERVER['PHP_SELF'] == '/admin/imagini/index.php' || $_SERVER['PHP_SELF'] == '/admin/imagini/adaugare_imagine.php' ? 'active text-white' : '' ?>" aria-current="page"><i class="fa-solid fa-image"></i>
                Imagini
            </a>
        </li>
    </ul>
</div>
    </div>
</div>