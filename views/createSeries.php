<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="row">
    <div class="col-12">
        <h1>Crear Serie</h1>
    </div>
    <div class="col-12">
        <form name="create_series" action="createSeries.php" method="POST">
            <div class="mb-3">
                <label for="serieTitle" class="form-label">Título de la Serie</label>
                <input id="serieTitle" name="serieTitle" type="text" placeholder="Introduce el título de la serie" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="serieDirector" class="form-label">Director</label>
                <select id="serieDirector" name="serieDirector" class="form-control" required>
                    <option value="">Selecciona un director</option>
                    <?php
                        require_once("../controllers/DirectorController.php");
                        $directorController = new DirectorController();
                        $directors = $directorController->listDirectors();

                        foreach ($directors as $director) {
                            echo "<option value='" . $director->getId() . "'>" . $director->getName() . " " . $director->getSurname() . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="seriePlatform" class="form-label">Plataforma</label>
                <select id="seriePlatform" name="seriePlatform" class="form-control" required>
                    <option value="">Selecciona una plataforma</option>
                    <?php
                        require_once("../controllers/PlatformController.php");
                        $platformController = new PlatformController();
                        $platforms = $platformController->listPlatforms();

                        foreach ($platforms as $platform) {
                            echo "<option value='" . $platform->getId() . "'>" . $platform->getName() . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="serieActors" class="form-label">Actores</label>
                <select id="serieActors" name="serieActors[]" class="form-control" multiple required>
                    <?php
                        require_once("../controllers/ActorController.php");
                        $actorController = new ActorController();
                        $actors = $actorController->listActors();

                        foreach ($actors as $actor) {
                            echo "<option value='" . $actor->getId() . "'>" . $actor->getName() . " " . $actor->getSurname() . "</option>";
                        }
                    ?>
                </select>
                <small class="form-text text-muted">Mantén pulsada la tecla Ctrl o Cmd para seleccionar varios actores.</small>
            </div>
            <div class="mb-3">
                <label for="audioLanguages" class="form-label">Idiomas de audio</label>
                <select id="audioLanguages" name="audioLanguages[]" class="form-control" multiple required>
                    <?php
                        require_once("../controllers/LanguageController.php");
                        $lanController = new LanguageController();
                        $audioLanguages = $lanController->listLanguages();

                        foreach ($audioLanguages as $audioLanguage) {
                            echo "<option value='" . $audioLanguage->getId() . "'>" . $audioLanguage->getName() . "</option>";
                        }
                    ?>
                </select>
                <small class="form-text text-muted">Mantén pulsada la tecla Ctrl o Cmd para seleccionar varios idiomas de audio.</small>
            </div>
            <div class="mb-3">
                <label for="subtitleLanguages" class="form-label">Idiomas de subtítulos</label>
                <select id="subtitleLanguages" name="subtitleLanguages[]" class="form-control" multiple required>
                    <?php
                        require_once("../controllers/LanguageController.php");
                        $lanController = new LanguageController();
                        $subtitleLanguages = $lanController->listLanguages();

                        foreach ($subtitleLanguages as $subtitleLanguage) {
                            echo "<option value='" . $subtitleLanguage->getId() . "'>" . $subtitleLanguage->getName() . "</option>";
                        }
                    ?>
                </select>
                <small class="form-text text-muted">Mantén pulsada la tecla Ctrl o Cmd para seleccionar varios idiomas de subtítulos.</small>
            </div>
            <input type="submit" value="Crear" class="btn btn-primary" name="createBtn"/>
        </form>
    </div>
</div>
<?php
    require_once("../controllers/SeriesController.php");

    $sendData = false;
    $seriesCreated = false;
    $seriesController = new SeriesController();

    if (isset($_POST['createBtn'])) {
        $sendData = true;
    }

    if ($sendData) {
        if(
            isset($_POST['serieTitle']) &&
            isset($_POST['serieDirector']) &&
            isset($_POST['seriePlatform']) &&
            isset($_POST['serieActors']) &&
            isset($_POST['audioLanguages']) &&
            isset($_POST['subtitleLanguages'])
        ) {
            // Procesamos la creación de la serie
            $seriesCreated = $seriesController->storeSerie(
                $_POST['serieTitle'],
                $_POST['serieDirector'],
                $_POST['seriePlatform'],
                $_POST['serieActors'],
                $_POST['audioLanguages'],
                $_POST['subtitleLanguages']
            );
        }
    }   

    if (!$sendData) {
        
    } else{
        if ($seriesCreated) {
            ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                    Serie creada correctamente.<br><a href="listSeries.php">Volver al listado de series.</a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    La serie no se ha creado correctamente.<br><a href="createSeries.php">Volver a intentarlo.</a>
                </div>
            </div>
            <?php 
        }
    }
?>