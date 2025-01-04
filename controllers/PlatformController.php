<?php

    require_once('../models/Platform.php');

    class PlatformController {
    
        // Constructor
        function __construct() {
        }

        function listPlatforms() {

            $model = new Platform(0, "");
            $platformList = $model->getAll();
            $platformObjectArray = [];

            foreach($platformList as $platformItem) {
                $platformObject = new Platform($platformItem->getId(), $platformItem->getName());
                array_push($platformObjectArray, $platformObject);
            }

            return $platformObjectArray;
        }

    }
?>