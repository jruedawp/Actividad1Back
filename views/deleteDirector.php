<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
        require_once("../controllers/DirectorController.php");

        $idDirector = $_POST['directorId'];
        $directorAux = new DirectorController();
        $directorDeleted = $directorAux->deleteDirector($idDirector);

        if($directorDeleted) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Director borrado correctamente. <br><a href="listDirector.php">Volver al listado de directores.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    El director no se ha borrado correctamente. <br><a href="deleteDirector.php">Volver a intentarlo.</a>
                </div>
            </div>
        <?php
        }
    ?>
</div>