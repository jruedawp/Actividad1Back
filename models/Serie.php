<?php
require_once("../models/Actor.php");
require_once("../models/Language.php");
require_once("../models/Director.php");
class Serie {
    private $id;
    private $title;
    private $platform;
    private $director;
    private $actors;
    private $audio_languages;
    private $subtitle_languages;

    // Constructor
    public function __construct($idSerie, $titleSerie, $platformSerie, $directorSerie, $actorsSerie, $audio_languagesSerie, $subtitle_languagesSerie) {
        $this->id = $idSerie;
        $this->title = $titleSerie;
        $this->platform = $platformSerie;
        $this->director = $directorSerie;
        $this->actors = $actorsSerie;
        $this->audio_languages = $audio_languagesSerie;
        $this->subtitle_languages = $subtitle_languagesSerie;
    }

    // Getters y Setters
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getPlatform() {
        return $this->platform;
    }

    public function setPlatform($platform) {
        $this->platform = $platform;
    }

    public function getDirector() {
        return $this->director;
    }

    public function setDirector($director) {
        $this->director = $director;
    }

    public function getActors() {
        return $this->actors;
    }

    public function setActors($actors) {
        $this->actors = $actors;
    }

    public function getAudioLanguages() {
        return $this->audio_languages;
    }

    public function setAudioLanguages($audio_languages) {
        $this->audio_languages = $audio_languages;
    }

    public function getSubtitleLanguages() {
        return $this->subtitle_languages;
    }

    public function setSubtitleLanguages($subtitle_languages) {
        $this->subtitle_languages = $subtitle_languages;
    }

    // Métodos CRUD

    // Obtener todas las series
    public function getAll() {
        $mysqli = $this->initConnectionDb();
        $listData = [];
    
        try {
            // Modificación principal: Añadir JOIN para plataformas y directores (nombre y apellidos)
            $query = $mysqli->query("
                SELECT 
                    s.*, 
                    p.nombre AS plataforma_nombre, 
                    d.nombre AS director_nombre, 
                    d.apellidos AS director_apellidos
                FROM 
                    series s
                LEFT JOIN 
                    plataformas p ON s.plataforma_id = p.id
                LEFT JOIN 
                    directores d ON s.director_id = d.id
                ORDER BY 
                    s.id ASC
            ");
    
            foreach ($query as $item) {
                // Recuperar los actores asociados a la serie
                $actorsQuery = $mysqli->query("
                    SELECT * 
                    FROM actores 
                    INNER JOIN series_actores ON actores.id = series_actores.actor_id 
                    WHERE series_actores.serie_id = " . $item['id']
                );
                $actors = [];
                foreach ($actorsQuery as $actorItem) {
                    $actors[] = new Actor($actorItem['id'], $actorItem['nombre'], $actorItem['apellidos'], $actorItem['fecha_nacimiento'], $actorItem['nacionalidad']);
                }

                // Guardamos los nombres de los actores que participan en la serie
                $actorsFullnames = "";
                $counter = 1;
                foreach ($actors as $actorAux) {
                    if ($counter < count($actors)) {
                        $conc = ", ";
                        $counter++;
                    }
                    else {
                        $conc = "";
                    }
                    $actorsFullnames = $actorsFullnames . $actorAux->getName() . " " . $actorAux->getSurname() . $conc;
                }
    
                // Recuperar los idiomas de audio
                $audioQuery = $mysqli->query("
                    SELECT * 
                    FROM idiomas 
                    INNER JOIN series_idiomas_audio ON idiomas.id = series_idiomas_audio.idioma_id 
                    WHERE series_idiomas_audio.serie_id = " . $item['id']
                );
                $audioLanguages = [];
                foreach ($audioQuery as $audioItem) {
                    $audioLanguages[] = new Language($audioItem['id'], $audioItem['nombre'], $audioItem['iso_code']);
                }

                // Guardamos los idiomas de audio concatenados
                $audioLan = "";
                $counter = 1;
                foreach ($audioLanguages as $audioAux) {
                    if ($counter < count($audioLanguages)) {
                        $conc = ", ";
                        $counter++;
                    }
                    else {
                        $conc = "";
                    }
                    $audioLan = $audioLan . $audioAux->getName() . $conc;
                }
    
                // Recuperar los idiomas de subtítulos
                $subtitleQuery = $mysqli->query("
                    SELECT * 
                    FROM idiomas 
                    INNER JOIN series_idiomas_subtitulos ON idiomas.id = series_idiomas_subtitulos.idioma_id 
                    WHERE series_idiomas_subtitulos.serie_id = " . $item['id']
                );
                $subtitleLanguages = [];
                foreach ($subtitleQuery as $subtitleItem) {
                    $subtitleLanguages[] = new Language($subtitleItem['id'], $subtitleItem['nombre'], $subtitleItem['iso_code']);
                }

                // Guardamos los subtítulos concatenados
                $subLan = "";
                $counter = 1;
                foreach ($subtitleLanguages as $subAux) {
                    if ($counter < count($subtitleLanguages)) {
                        $conc = ", ";
                        $counter++;
                    }
                    else {
                        $conc = "";
                    }
                    $subLan = $subLan . $subAux->getName() . $conc;
                }
                
    
                // Crear el objeto Serie con los datos obtenidos
                $itemObject = new Serie(
                    $item['id'],
                    $item['titulo'],
                    $item['plataforma_nombre'],
                    $item['director_nombre'] . " " . $item['director_apellidos'],
                    $actorsFullnames,
                    $audioLan,
                    $subLan
                );
        
                array_push($listData, $itemObject);
            }
        } catch (PDOException $e) {
            echo 'Error executing query: ' . $e->getMessage();
        }
    
        return $listData;
    }
    

    // Crear una serie
    public function store() {
        $mysqli = $this->initConnectionDb();
        $serieCreated = false;

        try {
            $mysqli->query("INSERT INTO series (titulo, plataforma_id, director_id) VALUES ('$this->title', '$this->platform', '$this->director')");
            // Después de insertar la serie, manejar las relaciones muchos a muchos:
            // Obtener el ID de la serie recién insertada
            $serieId = $mysqli->lastInsertId();

            // Insertar los actores, idiomas de audio y subtítulos
            $this->insertActors($serieId);
            $this->insertLanguages($serieId, $this->audio_languages, $this->subtitle_languages);

            $serieCreated = true;
        } catch (PDOException $e) {
            echo 'Error executing query: ' . $e->getMessage();
        }

        return $serieCreated;
    }

    // Insertar los actores asociados a la serie
    private function insertActors($serieId) {
        $mysqli = $this->initConnectionDb();

        foreach ($this->actors as $actorId) {
            $mysqli->query("INSERT INTO series_actores (serie_id, actor_id) VALUES ('$serieId', '$actorId')");
        }
    }

    // Insertar los idiomas de audio y subtítulos
    private function insertLanguages($serieId, $audioLanguages, $subtitleLanguages) {
        $mysqli = $this->initConnectionDb();

        foreach ($audioLanguages as $audioLanguageId) {
            $mysqli->query("INSERT INTO series_idiomas_audio (serie_id, idioma_id) VALUES ('$serieId', '$audioLanguageId')");
        }
        foreach ($subtitleLanguages as $subtitleLanguageId) {
            $mysqli->query("INSERT INTO series_idiomas_subtitulos (serie_id, idioma_id) VALUES ('$serieId', '$subtitleLanguageId')");
        }
    }

    // Editar una serie
    public function update() {
        $serieEdited = false;
        $mysqli = $this->initConnectionDb();

        // Comprobar si la serie existe antes de actualizar
        $query = $mysqli->query("SELECT * FROM series WHERE id = $this->id");
        if ($query->rowCount() > 0) {
            // La serie existe, proceder a la actualización
            if ($query = $mysqli->query("UPDATE series SET 
                titulo = '$this->title', 
                plataforma_id = '$this->platform', 
                director_id = '$this->director' 
                WHERE id = $this->id")) {
                
                // Actualizar los actores, idiomas de audio y subtítulos (relaciones N:M)
                $this->updateActors($mysqli);
                $this->updateAudioLanguages($mysqli);
                $this->updateSubtitleLanguages($mysqli);

                $serieEdited = true;
            }
        } else {
            // Si la serie no existe, no se puede editar
            $serieEdited = false;
        }

        return $serieEdited;
    }

    // Actualizar los actores de la serie
    private function updateActors($mysqli) {
        // Eliminar actores anteriores
        $mysqli->query("DELETE FROM series_actores WHERE serie_id = $this->id");

        // Insertar los nuevos actores seleccionados
        foreach ($this->actors as $actorId) {
            $mysqli->query("INSERT INTO series_actores (serie_id, actor_id) VALUES ($this->id, $actorId)");
        }
    }

    // Actualizar los idiomas de audio de la serie
    private function updateAudioLanguages($mysqli) {
        // Eliminar los idiomas de audio anteriores
        $mysqli->query("DELETE FROM series_idiomas_audio WHERE serie_id = $this->id");

        // Insertar los nuevos idiomas de audio seleccionados
        foreach ($this->audio_languages as $audioLang) {
            $mysqli->query("INSERT INTO series_idiomas_audio (serie_id, idioma_id) VALUES ($this->id, '$audioLang')");
        }
    }

    // Actualizar los idiomas de subtítulos de la serie
    private function updateSubtitleLanguages($mysqli) {
        // Eliminar los idiomas de subtítulos anteriores
        $mysqli->query("DELETE FROM series_idiomas_subtitulos WHERE serie_id = $this->id");

        // Insertar los nuevos idiomas de subtítulos seleccionados
        foreach ($this->subtitle_languages as $subLang) {
            $mysqli->query("INSERT INTO series_idiomas_subtitulos (serie_id, idioma_id) VALUES ($this->id, '$subLang')");
        }
    }

    // Obtener serie por id
    public function getItem() {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM series WHERE id = " . $this->id);

        // Traer los detalles de la serie
        foreach ($query as $item) {
            $serieObject = new Serie($item["id"], $item["titulo"], ["plataforma_id"], $item["director_id"], [], [], []);
            break;
        }

        // Obtener el director, actores, idiomas de audio y subtítulos
        $serieObject->director = $this->getDirectorById($serieObject->director);
        $serieObject->actors = $this->getActorsBySerieId($serieObject->id);
        $serieObject->audio_languages = $this->getAudioLanguagesBySerieId($serieObject->id);
        $serieObject->subtitle_languages = $this->getSubtitleLanguagesBySerieId($serieObject->id);

        return $serieObject;
    }

    // Obtener director por id
    private function getDirectorById($directorId) {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM directores WHERE id = " . $directorId);
        foreach ($query as $director) {
            $itemObject = new Director($director["id"], $director["nombre"], $director["apellidos"], $director['fecha_nacimiento'], $director['nacionalidad']);
            break;
        }
        return $itemObject;
    }

    // Obtener actores por serie_id
    private function getActorsBySerieId($serieId) {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT *
                                FROM actores a
                                JOIN series_actores sa ON a.id = sa.actor_id
                                WHERE sa.serie_id = " . $serieId);

        $actors = [];
        foreach ($query as $actor) {
            $actors[] = new Actor($actor["id"], $actor["nombre"], $actor["apellidos"], $actor["fecha_nacimiento"], $actor["nacionalidad"]);
        }

        return $actors;
    }

    // Obtener idiomas de audio por serie_id
    private function getAudioLanguagesBySerieId($serieId) {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * 
                                FROM idiomas
                                JOIN series_idiomas_audio sa ON idiomas.id = sa.idioma_id
                                WHERE sa.serie_id = " . $serieId);

        $audioLanguages = [];
        foreach ($query as $audioLang) {
            $audioLanguages[] = new Language($audioLang["id"], $audioLang["nombre"], $audioLang["iso_code"]);
        }

        return $audioLanguages;
    }

    // Obtener idiomas de subtítulos por serie_id
    private function getSubtitleLanguagesBySerieId($serieId) {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * 
                                FROM idiomas
                                JOIN series_idiomas_subtitulos si ON idiomas.id = si.idioma_id
                                WHERE si.serie_id = " . $serieId);

        $subLanguages = [];
        foreach ($query as $subLang) {
            $subLanguages[] = new Language($subLang["id"], $subLang["nombre"], $subLang["iso_code"]);
        }

        return $subLanguages;
    }

    // Borrar una serie
    public function delete() {
        $seriesDeleted = false;
        $mysqli = $this->initConnectionDb();

        // Comprobar que la serie existe
        $queryCheck = $mysqli->query("SELECT * FROM series WHERE id = " . $this->id);
        if ($queryCheck->rowCount() === 0) {
            return $seriesDeleted; // No existe la serie
        }

        // Borrar las relaciones en las tablas intermedias
        $mysqli->query("DELETE FROM series_actores WHERE serie_id = " . $this->id);
        $mysqli->query("DELETE FROM series_idiomas_audio WHERE serie_id = " . $this->id);
        $mysqli->query("DELETE FROM series_idiomas_subtitulos WHERE serie_id = " . $this->id);

        // Borrar la serie de la tabla principal
        if ($mysqli->query("DELETE FROM series WHERE id = " . $this->id)) {
            $seriesDeleted = true;
        }

        return $seriesDeleted;
    }



    // Conectar a la base de datos
    function initConnectionDb() {
        $db_host = 'aws-0-eu-central-1.pooler.supabase.com';
        $db_user = 'postgres.vjkabbrffyeioopthdal';
        $db_password = 'qfr2xT5*jpMjmcH';
        $db_port = '6543';
        $db_name = 'postgres';

        try {
            $connection = new PDO(
                "pgsql:host=$db_host;port=$db_port;dbname=$db_name;sslmode=require",
                $db_user,
                $db_password
            );

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}

?>
