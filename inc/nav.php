<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Audit energetic</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../page_ed.php">Pagina educativa</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <?php if (isset($is_logged)) { ?>
                        <li class="nav-item">
                            <a class="nav-link  " href="../my_account/index.php">Contul meu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../my_account/index.php?logout">Iesire</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Conectare</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../register.php">Inregistrare</a>
                        </li>
                    <?php } ?>
                </ul>
            </form>
        </div>
    </div>
</nav>