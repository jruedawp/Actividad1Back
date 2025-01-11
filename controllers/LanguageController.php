<?php

    require_once('../models/Language.php');

    class LanguageController {
    
        // Constructor
        public function __construct() {
        }

        // Listar todos los idiomas
        public function listLanguages() {

            $model = new Language(null, "", "");
            $languageList = $model->getAll();
            $languageObjectArray = [];

            foreach($languageList as $languageItem) {
                $languageObject = new Language($languageItem->getId(), $languageItem->getName(), $languageItem->getIso());
                array_push($languageObjectArray, $languageObject);
            }

            return $languageObjectArray;
        }

        // Crear un idioma
        public function storeLanguage ($nameLan, $isoLan) {

            $newLanguage = new Language(null, $nameLan, $isoLan);
            $languageCreated = $newLanguage->store();

            return $languageCreated;
        }

        // Editar un idioma
        public function updateLanguage ($lanId, $lanName, $lanIso) {
            $language = new Language($lanId, $lanName, $lanIso);

            $languageEdited = $language->update();

            return $languageEdited;
        }

        // Obtener idioma por id
        public function getLanguageData ($idLanguage) {
            $language = new Language($idLanguage, "", "");
            $languageObject = $language->getItem();

            return $languageObject;
        }

        // Borrar un idioma
        public function deleteLanguage ($languageId) {
            $language = new Language($languageId, "", "");
            $languageDeleted = $language->delete();

            return $languageDeleted;
        }

    }
?>