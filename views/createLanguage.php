<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="row">
    <div class="col-12">
        <h1>Crear idioma</h1>
    </div>
    <div class="col-12">
        <form name="create_language" action="" method="POST">
            <div class="mb-3">
                <label for="languageName" class="form-label">Idioma</label>
                <input id="languageName" name="languageName" type="text" placeholder="Introduce el idioma" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label for="languageISO" class="form-label">Idioma</label>
                <input id="languageISO" name="languageISO" type="text" placeholder="Introduce el código ISO" class="form-control" required/>
            </div>
            <input type="submit" value="Crear" class="btn btn-primary" name="createBtn"/>
        </form>
    </div>

</div>
<?php
    require_once("../controllers/LanguageController.php");

    $sendData = false;
    $languageCreated = false;
    $languageAux = new LanguageController();

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if(isset($_POST['languageName']) &&
            isset($_POST['languageISO'])) {
            $languageCreated = $languageAux->storeLanguage($_POST['languageName'], $_POST['languageISO']);
        }
    }

    if (!$sendData) {
?>
<?php
    } else{
        if ($languageCreated) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Plataforma creada correctamente.<br><a href="listLanguage.php">Volver al listado de idiomas.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    La plataforma no se ha creado correctamente.<br><a href="createLanguage.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>