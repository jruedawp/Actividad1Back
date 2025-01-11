<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
        require_once("../controllers/SeriesController.php");

        $idSeries = $_POST['seriesId'];
        $seriesAux = new SeriesController();
        $seriesDeleted = $seriesAux->deleteSeries($idSeries);

        if ($seriesDeleted) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Serie borrada correctamente. <br><a href="listSeries.php">Volver al listado de series.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    La serie no se ha borrado correctamente. <br><a href="listSeries.php">Volver al listado de series.</a>
                </div>
            </div>
            <?php
        }
    ?>
</div>
