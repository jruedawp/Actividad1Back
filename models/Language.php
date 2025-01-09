<?php

class Language {
    private $id;
    private $name;
    private $iso;

    // Constructores
    public function __construct($idLan, $nameLan, $isoLan) {
        $this->id = $idLan;
        $this->name = $nameLan;
        $this->iso = $isoLan;
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

    public function getIso() {
        return $this->iso;
    }

    public function setIso($isoLan) {
        $this->iso = $isoLan;
    }

    // Métodos CRUD

    // Obtener todos los idiomas
    public function getAll() {
        $mysqli = $this->initConnectionDb();

        try {
            $query = $mysqli->query("SELECT * FROM idiomas ORDER BY id ASC");
        } catch (PDOException $e) {
            echo 'Error executing query: ' . $e->getMessage();  
        }
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Language($item['id'], $item['nombre'], $item['iso_code']);
            array_push($listData, $itemObject);            
        }
        return $listData;
    }

    // Crear un idioma
    public function store() {
        $lanCreated = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que no existe ya el mismo idioma
        if ($resultInsert = $mysqli->query("INSERT INTO idiomas (nombre, iso_code) VALUES (' $this->name ', '$this->iso')")) {
            $lanCreated = true;
        }
        return $lanCreated;
    }

    // Editar un idioma
    public function update() {
        $lanEdited = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que existe antes de editar
        if ($query = $mysqli->query("UPDATE idiomas SET nombre = '$this->name', iso_code = '$this->iso' WHERE id =  $this->id")) {
            $lanEdited = true;
        }
        return $lanEdited;
    }

    // Obtener idioma por id
    public function getItem() {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM idiomas WHERE id = " . $this->id);

        foreach ($query as $item) {
            $itemObject = new Language($item["id"], $item["nombre"], $item['iso_code']);
            break;
        }

        return $itemObject;
    }

    // Borrar un actor
    public function delete() {
        $lanDeleted = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que existe antes de borrar
        if ($query = $mysqli->query("DELETE FROM idiomas WHERE id =". $this->id)) {
            $lanDeleted = true;
        }

        return $lanDeleted;
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
