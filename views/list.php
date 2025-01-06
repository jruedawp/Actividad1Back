<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="col-12">
    <?php
        require_once '../controllers/PlatformController.php';

        $platformController = new PlatformController();

        $platformList = $platformController->listPlatforms();

        if(count($platformList) > 0) {
    ?>   
    <table class='table'>
        <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
            foreach($platformList as $platform) {
            ?>
                <tr>
                    <td><?php echo $platform->getId();?></td>
                    <td><?php echo $platform->getName();?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-success" href="edit.php?id=<?php echo $platform->getId();?>">Editar</a>

                            <form name="delete_platform" action="delete.php" method="POST" style="...">
                                <input type="hidden" name="platformId" value="<?php echo $platform->getId();?>" />
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
        Aún no existen plataformas.
    </div>
    <?php
        }
    ?>
</div>