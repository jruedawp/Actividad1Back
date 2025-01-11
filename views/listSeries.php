<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="col-12">
    <?php
        require_once '../controllers/SeriesController.php';

        $seriesController = new SeriesController();
        $seriesList = $seriesController->listSeries();

        if (count($seriesList) > 0) {
    ?>   
    <table class='table'>
        <thead>
            <th>Título</th>
            <th>Plataforma</th>
            <th>Director</th>
            <th>Actores</th>
            <th>Idiomas de audio</th>
            <th>Idiomas de subtítulos</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
            foreach ($seriesList as $serie) {
            ?>
                <tr>
                    <td><?php echo $serie->getTitle(); ?></td>
                    <td><?php echo $serie->getPlatform(); ?></td>
                    <td><?php echo $serie->getDirector(); ?></td>
                    <td><?php echo $serie->getActors();?></td>
                    <td><?php echo $serie->getAudioLanguages();?></td>
                    <td><?php echo $serie->getSubtitleLanguages();?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-success" href="editSeries.php?id=<?php echo $serie->getId();?>">Editar</a>

                            <form name="delete_serie" action="deleteSeries.php" method="POST" style="...">
                                <input type="hidden" name="seriesId" value="<?php echo $serie->getId();?>" />
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
        } else {
    ?>
    <div class="alert alert-warning" role="alert">
        Aún no existen series.
    </div>
    <?php
        }
    ?>
    <a href="../index.html" class="btn btn-primary">Volver al inicio</a>
</div>
