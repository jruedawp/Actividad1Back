<?php

    require_once('../models/Actor.php');

    class ActorController {
    
        // Constructor
        public function __construct() {
        }

        // Listar todos los actores
        public function listActors() {

            $model = new Actor(null, "", "", "", "");
            $actorList = $model->getAll();
            $actorObjectArray = [];

            foreach($actorList as $actorItem) {
                $actorObject = new Actor($actorItem->getId(), $actorItem->getName(), $actorItem->getSurname(), $actorItem->getBirthDate(), $actorItem->getNationality());
                array_push($actorObjectArray, $actorObject);
            }

            return $actorObjectArray;
        }

        // Crear un actor
        public function storeActor ($actorName, $actorSurname, $actorBirth_Date, $actorNationality) {

            $newActor = new Actor(null, $actorName, $actorSurname, $actorBirth_Date, $actorNationality);
            $actorCreated = $newActor->store();

            return $actorCreated;
        }

        // Editar un actor
        public function updateActor ($actorId, $actorName, $actorSurname, $actorBirth_Date, $actorNationality) {
            $actor = new Actor($actorId, $actorName, $actorSurname, $actorBirth_Date, $actorNationality);

            $actorEdited = $actor->update();

            return $actorEdited;
        }

        // Obtener actor por id
        public function getActorData ($idActor) {
            $actor = new Actor($idActor, "", "", "", "");
            $actorObject = $actor->getItem();

            return $actorObject;
        }

        // Borrar un actor
        public function deleteActor ($actorId) {
            $actor = new Actor($actorId, "", "", "", "");
            $actorDeleted = $actor->delete();

            return $actorDeleted;
        }

    }
?>