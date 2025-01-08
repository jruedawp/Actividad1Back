<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="col-12">
    <?php
        require_once '../controllers/DirectorController.php';

        $directorController = new DirectorController();

        $directorList = $directorController->listDirectors();

        if(count($directorList) > 0) {
    ?>   
    <table class='table'>
        <thead>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Fecha de nacimiento</th>
            <th>Nacionalidad</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php
            foreach($directorList as $director) {
            ?>
                <tr>
                    <td><?php echo $director->getName();?></td>
                    <td><?php echo $director->getSurname();?></td>
                    <td><?php echo $director->getBirthDate();?></td>
                    <td><?php echo $director->getNationality();?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-success" href="editdirector.php?id=<?php echo $director->getId();?>">Editar</a>

                            <form name="delete_director" action="deletedirector.php" method="POST" style="...">
                                <input type="hidden" name="directorId" value="<?php echo $director->getId();?>" />
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
        Aún no existen directores.
    </div>
    <?php
        }
    ?>
    <a href="../index.html" class="btn btn-primary">Volver al inicio</a>
</div>