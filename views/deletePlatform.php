<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
        require_once("../controllers/PlatformController.php");

        $idPlatform = $_POST['platformId'];
        $platformAux = new PlatformController();
        $platformDeleted = $platformAux->deletePlatform($idPlatform);

        if($platformDeleted) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Plataforma borrada correctamente. <br><a href="listPlatform.php">Volver al listado de plataformas.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    La plataforma no se ha borrado correctamente. <br><a href="deletePlatform.php">Volver a intentarlo.</a>
                </div>
            </div>
        <?php
        }
    ?>
</div>