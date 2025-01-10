<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="row">
    <div class="col-12">
        <h1>Crear Director</h1>
    </div>
    <div class="col-12">
        <form name="create_director" action="createDirector.php" method="POST">
            <div class="mb-3">
                <label for="directorName" class="form-label">Nombre del Director</label>
                <input id="directorName" name="directorName" type="text" placeholder="Introduce el nombre del director" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="directorSurname" class="form-label">Apellido</label>
                <input id="directorSurname" name="directorSurname" type="text" placeholder="Introduce el apellido" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="directorBirthDate" class="form-label">Fecha de nacimiento</label>
                <input id="directorBirthDate" name="directorBirthDate" type="date" placeholder="Introduce la fecha de nacimiento" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="directorNationality" class="form-label">Nacionalidad</label>
                <input id="directorNationality" name="directorNationality" type="text" placeholder="Introduce la nacionalidad" class="form-control" required/>
            </div>
            <input type="submit" value="Crear" class="btn btn-primary" name="createBtn"/>
        </form>
    </div>
</div>


<?php
    require_once("../controllers/DirectorController.php");

    $sendData = false;
    $directorCreated = false;
    $directorAux = new DirectorController();

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if(
        isset($_POST['directorName']) &&
        isset($_POST['directorSurname']) &&
        isset($_POST['directorBirthDate']) &&
        isset($_POST['directorNationality'])
        ) {
            $directorCreated = $directorAux->storeDirector(
                $_POST['directorName'],
                $_POST['directorSurname'],
                $_POST['directorBirthDate'],
                $_POST['directorNationality']
            );
        }
    }   
        if (!$sendData) {
?>
<?php
    } else{
        if ($directorCreated === true) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Director creado correctamente.<br><a href="listDirector.php">Volver al listado de directores.</a>
                </div>
            </div>
            <?php
        } else if($directorCreated === "repetido") {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    Ya existe un director con ese nombre y apellidos.<br><a href="createDirector.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }else{
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    El director no se ha creado correctamente.<br><a href="createDirector.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>