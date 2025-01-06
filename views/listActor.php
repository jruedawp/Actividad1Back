<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="col-12">
    <?php
        require_once '../controllers/ActorController.php';

        $actorController = new ActorController();

        $actorList = $actorController->listactors();

        if(count($actorList) > 0) {
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
            foreach($actorList as $actor) {
            ?>
                <tr>
                    <td><?php echo $actor->getName();?></td>
                    <td><?php echo $actor->getSurname();?></td>
                    <td><?php echo $actor->getBirthDate();?></td>
                    <td><?php echo $actor->getNationality();?></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a class="btn btn-success" href="editactor.php?id=<?php echo $actor->getId();?>">Editar</a>

                            <form name="delete_actor" action="deleteactor.php" method="POST" style="...">
                                <input type="hidden" name="actorId" value="<?php echo $actor->getId();?>" />
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
        Aún no existen actores.
    </div>
    <?php
        }
    ?>
</div>