<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <?php
        require_once("../controllers/LanguageController.php");

        $idLanguage = $_POST['languageId'];
        $languageAux = new LanguageController();
        $languageDeleted = $languageAux->deleteLanguage($idLanguage);

        if($languageDeleted) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Idioma borrado correctamente. <br><a href="listLanguage.php">Volver al listado de idiomas.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    El idioma no se ha borrado correctamente. <br><a href="listLanguage.php">Volver al listado de idiomas.</a>
                </div>
            </div>
        <?php
        }
    ?>
</div>