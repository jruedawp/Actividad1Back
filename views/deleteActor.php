<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
        require_once("../controllers/ActorController.php");

        $idActor = $_POST['actorId'];
        $actorAux = new ActorController();
        $actorDeleted = $actorAux->deleteActor($idActor);

        if($actorDeleted) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Actor borrado correctamente. <br><a href="listActor.php">Volver al listado de actores.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    El actor no se ha borrado correctamente. <br><a href="listActor.php">Volver al listado de actores.</a>
                </div>
            </div>
        <?php
        }
    ?>
</div>