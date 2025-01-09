<?php

    require_once('../models/Director.php');

    class DirectorController {
    
        // Constructor
        public function __construct() {
        }

        // Listar todos los directores
        public function listDirectors() {
            $model = new Director(null, "", "", "", "");
            $directorList = $model->getAll();
            $directorObjectArray = [];

            foreach($directorList as $directorItem) {
                $directorObject = new Director($directorItem->getId(), $directorItem->getName(), $directorItem->getSurname(), $directorItem->getBirthDate(), $directorItem->getNationality());
                array_push($directorObjectArray, $directorObject);
            }

            return $directorObjectArray;
        }

        // Crear un director
        public function storeDirector ($directorName, $directorSurname, $directorBirthDate, $directorNationality) {
            $newDirector = new Director(null, $directorName, $directorSurname, $directorBirthDate, $directorNationality);
            $directorCreated = $newDirector->store();

            return $directorCreated;
        }

        // Editar un Director
        public function updateDirector ($directorId, $directorName, $directorSurname, $directorBirthDate, $directorNationality) {
            $director = new Director($directorId, $directorName, $directorSurname, $directorBirthDate, $directorNationality);
            $directorEdited = $director->update();

            return $directorEdited;
        }

        // Obtener director por id
        public function getDirectorData ($idDirector) {
            $directorObject = new Director($idDirector, "", "", "", "");
            return $directorObject->getItem();
        }

        // Borrar un director
        public function deleteDirector ($directorId) {
            $director = new Director($directorId, "","","","");
            $directorDeleted = $director->delete();

            return $directorDeleted;
        }
    }
?>