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
            $query = $mysqli->query("SELECT * FROM plataformas");
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

        // TODO: Comprobar que no existe otra plataforma con el mismo nombre
        if ($resultInsert = $mysqli->query("INSERT INTO plataformas (nombre) VALUES (' $this->name ')")) {
            $platformCreated = true;
        }
        return $platformCreated;
    }

    // Editar una plataforma
    public function update() {
        $platformEdited = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que existe antes de editar
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

    // Conectar a la Base de Datos
    function initConnectionDb() {
        $db_host = 'aws-0-eu-central-1.pooler.supabase.com';
        $db_user = 'postgres.vjkabbrffyeioopthdal';
        $db_password = 'qfr2xT5*jpMjmcH';
        $db_port = '6543';
        $db_name = 'postgres';

        /* $mysqli = @new mysqli {
            $db_host,
            $db_user,
            $db_port,
            $db_password,
            $db_name
        }; */

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
