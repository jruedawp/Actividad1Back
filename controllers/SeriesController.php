<?php

require_once('../models/Serie.php');

class SeriesController {

    // Constructor
    public function __construct() {}

    // Listar todas las series
    public function listSeries() {
        $model = new Serie(null, "", "", "", [], [], []);
        $seriesList = $model->getAll();  // Obtener todas las series desde el modelo
    
        // Crear un array de objetos Serie con los valores completos
        $seriesObjectArray = [];
        foreach ($seriesList as $serieItem) {    
            // Ahora pasamos los valores correctamente formateados
            $serieObject = new Serie(
                $serieItem->getId(), 
                $serieItem->getTitle(), 
                $serieItem->getPlatform(),
                $serieItem->getDirector(),
                $serieItem->getActors(), 
                $serieItem->getAudioLanguages(),
                $serieItem->getSubtitleLanguages()
            );
            array_push($seriesObjectArray, $serieObject);
        }
    
        return $seriesObjectArray;
    }
    

    // Obtener una serie por ID
    public function getSerieData($idSerie) {
        $serie = new Serie($idSerie, "", "", "", [], [], []);
        $serieObject = $serie->getAll();  // Obtener los datos completos de la serie

        return $serieObject;
    }

    // Crear una serie (similar al método de crear actor)
    public function storeSerie($title, $platform, $director, $actors, $audioLanguages, $subtitleLanguages) {
        $newSerie = new Serie(null, $title, $platform, $director, $actors, $audioLanguages, $subtitleLanguages);
        return $newSerie->store();  // Método store en la clase Serie
    }

    // Editar una serie
    public function updateSeries($serieId, $serieTitle, $seriePlatform, $serieDirector, $serieActors, $serieAudioLanguages, $serieSubtitleLanguages) {
        $serie = new Serie($serieId, $serieTitle, $seriePlatform, $serieDirector, $serieActors, $serieAudioLanguages, $serieSubtitleLanguages);
    
        $serieEdited = $serie->update();
    
        return $serieEdited;
    }
    
    // Obtener una serie por su id
    public function getSeriesData($idSerie) {
        $serie = new Serie($idSerie, "", "", "", [], [], []);
        $serieObject = $serie->getItem();
    
        return $serieObject;
    }
    

    // Borrar una serie
    public function deleteSeries($idSerie) {
        // Crear instancia de la serie con el ID especificado
        $serie = new Serie($idSerie, "", "", "", [], [], []);

        // Intentar borrar la serie a través del método del modelo
        $seriesDeleted = $serie->delete();

        return $seriesDeleted;
    }

}
?>
