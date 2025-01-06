<?php

    require_once('../models/Platform.php');

    class PlatformController {
    
        // Constructor
        public function __construct() {
        }

        // Listar todas las plataformas
        public function listPlatforms() {

            $model = new Platform(0, "");
            $platformList = $model->getAll();
            $platformObjectArray = [];

            foreach($platformList as $platformItem) {
                $platformObject = new Platform($platformItem->getId(), $platformItem->getName());
                array_push($platformObjectArray, $platformObject);
            }

            return $platformObjectArray;
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

    }
?>