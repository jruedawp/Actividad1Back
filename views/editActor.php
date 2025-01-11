<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
    require_once("../controllers/ActorController.php");

    $idActor = $_GET['id'];
    $aux = new ActorController();
    $actorObject = $aux->getActorData($idActor);
    ?>
</div>
<div class="row">
    <div class="col-12">
        <h1>Editar Actor</h1>
    </div>
    <div class="col-12">
    <form name="create_actor" action="" method="POST">
    <div class="mb-3">
        <label for="actorName" class="form-label">Nombre del actor</label>
        <input id="actorName" name="actorName" type="text" placeholder="Introduce el nombre del actor" class="form-control" required value="<?php if(isset($actorObject)) echo $actorObject->getName(); ?>"/>
    </div>
    <div class="mb-3">
        <label for="actorSurname" class="form-label">Apellido del actor</label>
        <input id="actorSurname" name="actorSurname" type="text" placeholder="Introduce el apellido" class="form-control" required value="<?php if(isset($actorObject)) echo $actorObject->getSurname(); ?>"/>
    </div>
    <div class="mb-3">
        <label for="actorBirthDate" class="form-label">Fecha de nacimiento</label>
        <input id="actorBirthDate" name="actorBirthDate" type="date" placeholder="Introduce la fecha de nacimiento del actor" class="form-control" required value="<?php if(isset($actorObject)) echo $actorObject->getBirthDate(); ?>"/>
    </div>
    <div class="mb-3">
        <label for="actorNationality" class="form-label">Nacionalidad</label>
        <input id="actorNationality" name="actorNationality" type="text" placeholder="Introduce la nacionalidad del actor" class="form-control" required value="<?php if(isset($actorObject)) echo $actorObject->getNationality(); ?>"/>
    </div>
    <input type="hidden" name="actorId" value="<?php echo $idActor; ?>"/>
    <input type="submit" value="Editar" class="btn btn-primary" name="createBtn"/>
</form>
    </div>
</div>

<?php
    require_once("../controllers/ActorController.php");

    $sendData = false;
    $actorEdited = false;
    $actorAux = new ActorController();

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if (
            isset($_POST['actorId']) && 
            isset($_POST['actorName']) && 
            isset($_POST['actorSurname']) && 
            isset($_POST['actorBirthDate']) && 
            isset($_POST['actorNationality'])
        ) {
            $actorEdited = $actorAux->updateActor(
                $_POST['actorId'], 
                $_POST['actorName'], 
                $_POST['actorSurname'], 
                $_POST['actorBirthDate'], 
                $_POST['actorNationality'],
                $actorObject->getName(),
                $actorObject->getSurname()
            );
        }
    }
    
    if (!$sendData) {
?>

<?php
    } else{
       
        if ($actorEdited) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Actor editado correctamente.<br><a href="listActor.php">Volver al listado de actores</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                Ya existe un actor con ese nombre y apellidos. <br><a href="editActor.php?id=<?php echo $idActor; ?>">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>