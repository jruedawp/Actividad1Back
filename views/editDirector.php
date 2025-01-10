<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
    require_once("../controllers/DirectorController.php");

    $idDirector = $_GET['id'];
    $aux = new DirectorController();
    $directorObject = $aux->getDirectorData($idDirector);
    ?>
</div>

<div class="row">
    <div class="col-12">
        <h1>Editar Director</h1>
    </div>
    <div class="col-12">
    <form name="create_director" action="" method="POST">
    <div class="mb-3">
        <label for="directorName" class="form-label">Nombre del director</label>
        <input id="directorName" name="directorName" type="text" placeholder="Introduce el nombre del director" class="form-control" required value="<?php if(isset($directorObject)) echo $directorObject->getName(); ?>"/>
    </div>
    <div class="mb-3">
        <label for="directorSurname" class="form-label">Apellido del director</label>
        <input id="directorSurname" name="directorSurname" type="text" placeholder="Introduce el apellido" class="form-control" required value="<?php if(isset($directorObject)) echo $directorObject->getSurname(); ?>"/>
    </div>
    <div class="mb-3">
        <label for="directorBirthDate" class="form-label">Fecha de nacimiento</label>
        <input id="directorBirthDate" name="directorBirthDate" type="date" placeholder="Introduce la fecha de nacimiento del director" class="form-control" required value="<?php if(isset($directorObject)) echo $directorObject->getBirthDate(); ?>"/>
    </div>
    <div class="mb-3">
        <label for="directorNationality" class="form-label">Nacionalidad</label>
        <input id="directorNationality" name="directorNationality" type="text" placeholder="Introduce la nacionalidad del director" class="form-control" required value="<?php if(isset($directorObject)) echo $directorObject->getNationality(); ?>"/>
    </div>
    <input type="hidden" name="directorId" value="<?php echo $idDirector; ?>"/>
    <input type="submit" value="Editar" class="btn btn-primary" name="createBtn"/>
</form>
    </div>
</div>

<?php
    require_once("../controllers/DirectorController.php");

    $sendData = false;
    $directorEdited = false;
    $directorAux = new DirectorController();

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if (
            isset($_POST['directorId']) && 
            isset($_POST['directorName']) && 
            isset($_POST['directorSurname']) && 
            isset($_POST['directorBirthDate']) && 
            isset($_POST['directorNationality'])
        ) {
            $directorEdited = $directorAux->updateDirector(
                $_POST['directorId'], 
                $_POST['directorName'], 
                $_POST['directorSurname'], 
                $_POST['directorBirthDate'], 
                $_POST['directorNationality'],
                $directorObject->getName(),
                $directorObject->getSurname()

            );
        }
    }
    
    if (!$sendData) {
?>

<?php
    } else{
        if ($directorEdited) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Director editado correctamente.<br><a href="listDirector.php">Volver al listado de directores</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                   Ya existe un director con ese nombre y apellidos o no ha sido editado.<br><a href="editDirector.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>