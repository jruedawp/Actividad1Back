<?php

class Platform {
    private $id;
    private $name;

    // Constructores
    public function __construct($idPlatform, $namePlatform) {
        $this->id = $idPlatform;
        $this->name = $namePlatform;
    }

    // Getters y Setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Métodos CRUD

    // Obtener todas las plataformas
    public function getAll() {
        $mysqli = $this->initConnectionDb();

        try {
            $query = $mysqli->query("SELECT * FROM plataformas ORDER BY id ASC");
        } catch (PDOException $e) {
            echo 'Error executing query: ' . $e->getMessage();  
        }
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Platform($item['id'], $item['nombre']);
            array_push($listData, $itemObject);            
        }
        return $listData;
    }

    // Crear una plataforma
    public function store() {
        $platformCreated = false;
        $mysqli = $this->initConnectionDb();

        // Comprobar si ya existe un idioma con el mismo nombre o código ISO
        $checkQuery = "SELECT 1 FROM plataformas WHERE nombre = '" . $this->name . "'";
        $result = $mysqli->query($checkQuery);
        
        if ($result->rowCount()> 0) {
            return false;
        }
        if ($resultInsert = $mysqli->query("INSERT INTO plataformas (nombre) VALUES (' $this->name ')")) {
            $platformCreated = true;
        }
        return $platformCreated;
    }

    // Editar una plataforma
    public function update() {
        $platformEdited = false;
        $mysqli = $this->initConnectionDb();

        // Comprobar si ya existe un idioma con el mismo nombre o código ISO
        $checkQuery = "SELECT 1 FROM plataformas WHERE nombre = '" . $this->name . "'";
         $result = $mysqli->query($checkQuery);
                
        if ($result->rowCount()> 0) {
            return false;
        }       
        if ($query = $mysqli->query("UPDATE plataformas set nombre = '" . $this->name . "' WHERE id = " . $this->id)) {
            $platformEdited = true;
        }
        return $platformEdited;
    }

    // Obtener plataforma por id
    public function getItem() {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM plataformas WHERE id = " . $this->id);

        foreach ($query as $item) {
            $itemObject = new Platform($item["id"], $item["nombre"]);
            break;
        }

        return $itemObject;
    }

    // Borrar una plataforma
    public function delete() {
        $platformDeleted = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que existe antes de borrar
        if ($query = $mysqli->query("DELETE FROM plataformas WHERE id =". $this->id)) {
            $platformDeleted = true;
        }

        return $platformDeleted;
    }

    // Conectar a la Base de Datos
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
