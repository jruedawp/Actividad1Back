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

        // Crear una plataforma
        public function storePlatform ($platformName) {

            $newPlatform = new Platform(null, $platformName);
            $platformCreated = $newPlatform->store();

            return $platformCreated;
        }

        // Editar una plataforma
        public function updatePlatform ($platformId, $platformName) {
            $platform = new Platform($platformId, $platformName);

            $platformEdited = $platform->update();

            return $platformEdited;
        }

        // Obtener plataforma por id
        public function getPlatformData ($idPlatform) {
            $platform = new Platform($idPlatform, "");
            $platformObject = $platform->getItem();

            return $platformObject;
        }

        // Borrar una plataforma
        public function deletePlatform ($platformId) {
            $platform = new Platform($platformId, "");
            $platformDeleted = $platform->delete();

            return $platformDeleted;
        }

    }
?>