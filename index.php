<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/check_login.php';
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
            <button class="btn btn-primary my-2" type="button" name="submit" id="btnAdaugaAparatNou"><i
                        class="fa-solid fa-add"></i> Adauga aparat nou
            </button>
            <div class="bg-body-tertiary p-5 rounded row">
                <form action="rezultat.php" method="get">
                    <h1 class="h3 mb-3 fw-normal text-center">Introduceti datele despre consumul zilnic</h1>
                    <div id="consumersWrapper" class="d-flex flex-wrap">
                        <?php if (isset($_GET['recalculeaza']) && !empty($_GET['consumers'])) {
                            $i = 1;
                            foreach ($_GET['consumers'] as $consumer) {
                            ?>
                            <div class="col-md-6" id="consumer_<?php echo $i; ?>" data-localId="<?php echo $i; ?>">
                                <div class="card mb-5 mx-3">
                                    <div class="card-body">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="consumerBrand<?php echo $i; ?>"
                                                   placeholder="Marca consumator" name="consumers[<?php echo $i; ?>][brand]" value="<?php echo $consumer['brand'] ?>" required/>
                                            <label for="consumerBrand<?php echo $i; ?>">Marca consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="consumerEnergyClass<?php echo $i; ?>"
                                                   placeholder="Ore funcionare consumator" name="consumers[<?php echo $i; ?>][energyClass]" value="<?php echo $consumer['energyClass'] ?>" required/>
                                            <label for="consumerEnergyClass<?php echo $i; ?>">Clasa energetica consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="consumerName<?php echo $i; ?>" placeholder="Tip consumator"
                                                   name="consumers[<?php echo $i; ?>][name]" value="<?php echo $consumer['name'] ?>" required/>
                                            <label for="consumerName<?php echo $i; ?>">Tip consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="consumerCount<?php echo $i; ?>"
                                                   placeholder="Numar consumatori" name="consumers[<?php echo $i; ?>][count]" value="<?php echo $consumer['count'] ?>" required/>
                                            <label for="consumerCount<?php echo $i; ?>">Numar consumatori</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="consumerRunTime<?php echo $i; ?>"
                                                   placeholder="Ore funcionare consumator" name="consumers[<?php echo $i; ?>][runTime]" value="<?php echo $consumer['runTime'] ?>" required/>
                                            <label for="consumerRunTime<?php echo $i; ?>">Ore functionare consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="consumerPower<?php echo $i; ?>" placeholder="Putere (W)"
                                                   name="consumers[<?php echo $i; ?>][power]" value="<?php echo $consumer['power'] ?>" required/>
                                            <label for="consumerPower<?php echo $i; ?>">Putere (W)</label>
                                        </div>
                                        <?php if ($i > 1) { ?>
                                            <button class="btn btn-danger py-2 consumerDeleteButton" type="button" name="submit" id="btnStergeAparat" data-delete-id="consumer_<?php echo $i; ?>"><i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; } } else { ?>
                            <div class="col-md-6" id="consumer_1" data-localId="1">
                                <div class="card mb-5 mx-3">
                                    <div class="card-body">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="consumerBrand"
                                                   placeholder="Marca consumator" name="consumers[0][brand]" required/>
                                            <label for="consumerBrand">Marca consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="consumerEnergyClass"
                                                   placeholder="Ore funcionare consumator" name="consumers[0][energyClass]" required/>
                                            <label for="consumerEnergyClass">Clasa energetica consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="consumerName" placeholder="Tip consumator"
                                                   name="consumers[0][name]" required/>
                                            <label for="consumerName">Tip consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="consumerCount"
                                                   placeholder="Numar consumatori" name="consumers[0][count]" required/>
                                            <label for="consumerCount">Numar consumatori</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="consumerRunTime"
                                                   placeholder="Ore funcionare consumator" name="consumers[0][runTime]" required/>
                                            <label for="consumerRunTime">Ore functionare consumator</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="consumerPower" placeholder="Putere (W)"
                                                   name="consumers[0][power]" required/>
                                            <label for="consumerPower">Putere (W)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                    <button class="btn btn-primary w-100 py-2" type="submit" name="submit"><i
                                class="fa-solid fa-calculator"></i> Calculeaza
                    </button>
                </form>
            </div>
        </main>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/inc/javascript.php'; ?>
    </body>
</html>
