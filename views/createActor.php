<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="row">
    <div class="col-12">
        <h1>Crear Actor</h1>
    </div>
    <div class="col-12">
        <form name="create_actor" action="createActor.php" method="POST">
            <div class="mb-3">
                <label for="actorName" class="form-label">Nombre del Actor</label>
                <input id="actorName" name="actorName" type="text" placeholder="Introduce el nombre del actor" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="actorSurname" class="form-label">Apellido</label>
                <input id="actorSurname" name="actorSurname" type="text" placeholder="Introduce el apellido" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="actorBirthDate" class="form-label">Fecha de nacimiento</label>
                <input id="actorBirthDate" name="actorBirthDate" type="date" placeholder="Introduce la fecha de nacimiento" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="actorNationality" class="form-label">Nacionalidad</label>
                <input id="actorNationality" name="actorNationality" type="text" placeholder="Introduce la nacionalidad" class="form-control" required/>
            </div>
            <input type="submit" value="Crear" class="btn btn-primary" name="createBtn"/>
        </form>
    </div>
</div>


<?php
    require_once("../controllers/ActorController.php");

    $sendData = false;
    $actorCreated = false;
    $actorAux = new ActorController();

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if(
        isset($_POST['actorName']) &&
        isset($_POST['actorSurname']) &&
        isset($_POST['actorBirthDate']) &&
        isset($_POST['actorNationality'])
        ) {
            $actorCreated = $actorAux->storeActor(
                $_POST['actorName'],
                $_POST['actorSurname'],
                $_POST['actorBirthDate'],
                $_POST['actorNationality']
            );
        }
    }   
        if (!$sendData) {
?>
<?php
    } else{
        if ($actorCreated) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Actor creado correctamente.<br><a href="listActor.php">Volver al listado de actores.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    El actor no se ha creado correctamente.<br><a href="createActor.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>