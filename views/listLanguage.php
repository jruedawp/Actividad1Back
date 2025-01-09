<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="col-12">
    <?php
        require_once '../controllers/LanguageController.php';

        $languageController = new LanguageController();

        $languageList = $languageController->listLanguages();

        if(count($languageList) > 0) {
    ?>   
    <table class='table'>
        <thead>
            <th>Nombre</th>
            <th>Código ISO</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
            foreach($languageList as $language) {
            ?>
                <tr>
                    <td><?php echo $language->getName();?></td>
                    <td><?php echo $language->getIso();?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-success" href="editLanguage.php?id=<?php echo $language->getId();?>">Editar</a>

                            <form name="delete_language" action="deleteLanguage.php" method="POST" style="...">
                                <input type="hidden" name="languageId" value="<?php echo $language->getId();?>" />
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
        Aún no existen idiomas.
    </div>
    <?php
        }
    ?>
<a href="../index.html" class="btn btn-primary">Volver al inicio</a>
</div>