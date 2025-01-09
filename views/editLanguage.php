<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
    require_once("../controllers/LanguageController.php");

    $idLanguage = $_GET['id'];
    $aux = new LanguageController();
    $languageObject = $aux->getLanguageData($idLanguage);
    ?>
</div>
<div class="row">
    <div class="col-12">
        <h1>Editar plataforma</h1>
    </div>
    <div class="col-12">
        <form name="create_language" action="" method="POST">
            <div class="mb-3">
                <label for="languageName" class="form-label">Idioma</label>
                <input id="languageName" name="languageName" type="text" placeholder="Introduce el idioma" class="form-control" required value="<?php if(isset($languageObject)) echo $languageObject->getName(); ?>"/>
                <input type="hidden" name="languageId" value="<?php echo $idLanguage; ?>"/>
            </div>
            <div class="mb-3">
                <label for="languageName" class="form-label">Código ISO</label>
                <input id="languageName" name="languageISO" type="text" placeholder="Introduce el código ISO" class="form-control" required value="<?php if(isset($languageObject)) echo $languageObject->getIso(); ?>"/>
            </div>
            <input type="submit" value="Editar" class="btn btn-primary" name="createBtn"/>
        </form>
    </div>
</div>
<?php
    require_once("../controllers/LanguageController.php");

    $sendData = false;
    $languageEdited = false;

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if(isset($_POST['languageName']) &&
            isset($_POST['languageISO'])) {
            $languageEdited = $aux->updateLanguage($_POST['languageId'], $_POST['languageName'], $_POST['languageISO']);
        }
    }

    if (!$sendData) {
?>
<?php
    } else{
        if ($languageEdited) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Plataforma editada correctamente.<br><a href="listLanguage.php">Volver al listado de plataformas.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    La plataforma no se ha editado correctamente.<br><a href="editLanguage.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>