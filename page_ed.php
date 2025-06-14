<!doctype html>
<html lang="ro" data-bs-theme="auto">
    <head>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/head.php'; ?>
        <link href="/assets/css/page_ed.css" rel="stylesheet">
        <link href="/assets/css/carousel.css" rel="stylesheet">
    </head>
    <body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/theme_switcher.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>
    <main class="d-flex">
        <div class="container mt-5">
            <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/background_page_ed.jpg" class="d-block w-100" alt="Background pagina educativa">
                        <div class="container">
                            <div class="carousel-caption text-start">
                                <h1>Pagina educativa</h1>
                                <p class="opacity-75">Exploreaza informatii despre eficienta energetica si sustenabilitate!</p>
                                <p><a class="btn btn-lg btn-secondary" href="/login.php">Creeaza un cont</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="images/background_page_ed.jpg" class="d-block w-100" alt="Background pagina educativa">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Invata sa economisesti energie acasa.</h1>
                                <p>Exploreaza sfaturi practice si solutii moderne pentru un consum mai eficient.</p>
                                <p><a class="btn btn-lg btn-secondary" href="/page_ed.php">Afla mai multe</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="images/background_page_ed.jpg" class="d-block w-100" alt="Background pagina educativa">
                        <div class="container">
                            <div class="carousel-caption text-end">
                                <h1>Descopera galeria noastra educativa.</h1>
                                <p>Vizualizeaza imagini explicative, infografice si exemple din viata reala.</p>
                                <p><a class="btn btn-lg btn-secondary" href="/imagini/index.php">Vezi galeria</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="container-fluid marketing">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="images/articole.jpg" class="rounded-circle mb-3" alt="Articole" width="140" height="140">
                        <h2 class="fw-normal">Articole</h2>
                        <p>Descoperă articole utile despre eficiența energetică, economisire și tehnologii sustenabile.</p>
                        <p><a class="btn btn-secondary" href="/articole">Vezi detalii &raquo;</a></p>
                    </div>
                    <div class="col-lg-4">
                        <img src="images/grafice.jpg" class="rounded-circle mb-3" alt="Articole" width="140" height="140">
                        <h2 class="fw-normal">Grafice</h2>
                        <p>Analize vizuale, comparații și tendințe.</p>
                        <p><a class="btn btn-secondary" href="/grafice">Vezi detalii &raquo;</a></p>
                    </div>
                    <div class="col-lg-4">
                        <img src="images/imaginiPanou.jpg" class="rounded-circle mb-3" alt="Articole" width="140" height="140">
                        <h2 class="fw-normal">Imagini</h2>
                        <p>Galerie cu exemple reale, infografice și idei practice pentru o casă eficientă.</p>
                        <p><a class="btn btn-secondary" href="/imagini">Vezi detalii &raquo;</a></p>
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading fw-normal lh-1">Citește. Învață. Schimbă-ți perspectiva. <span class="text-body-secondary">Merită fiecare minut de lectură.</span></h2>
                        <h4 class="lead">Te vei uita altfel la factura de energie.</h4>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img src="images/articoleRead.jpg" class="img-fluid mx-auto d-block" alt="Articole" width="500" height="500">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7 order-md-2">
                        <h2 class="featurette-heading fw-normal lh-1">Vezi energia în cifre. <span class="text-body-secondary">Datele nu păcălesc..</span></h2>
                        <h4 class="lead">Vizual, logic, convingător.</h4>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img src="images/graficeRead.jpg" class="img-fluid mx-auto d-block" alt="Grafice" width="500" height="500">
                    </div>
                </div>

                <hr class="featurette-divider">

                <div class="row featurette">
                    <div class="col-md-7">
                        <h2 class="featurette-heading fw-normal lh-1">Aici realitatea prinde formă. <span class="text-body-secondary">Exemple vizuale. Zero confuzie.</span></h2>
                        <h4 class="lead">Totul e mai clar în imagini.</h4>
                    </div>
                    <div class="col-md-5 order-md-1">
                        <img src="images/imaginiRead.jpg" class="img-fluid mx-auto d-block" alt="Grafice" width="500" height="500">
                    </div>
                </div>
            </div>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
    </body>
</html>