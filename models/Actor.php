<?php

class Actor {
    private $id;
    private $name;
    private $surname;
    private $birth_date;
    private $nationality;

    // Constructores
    public function __construct($idActor, $nameActor, $surnameActor, $birth_date_actor, $nationalityActor) {
        $this->id = $idActor;
        $this->name = $nameActor;
        $this->surname = $surnameActor;
        $this->birth_date = $birth_date_actor;
        $this->nationality = $nationalityActor;
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

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getBirthDate() {
        try {
            $date = new DateTime($this->birth_date);
    
            // Devolver la fecha en el formato dd/mm/yyyy
            return $date->format("Y-m-d");
        } catch (Exception $e) {
            // Registrar el error y devolver un mensaje genérico
            error_log("Error al formatear la fecha: {$this->birth_date} - {$e->getMessage()}");
            return "Fecha inválida";
        }
    }
    
    

    public function setBirthDate($birth_date) {
        $this->birth_date = $birth_date;
    }

    public function getNationality() {
        return $this->nationality;
    }

    public function setNationality($nationality) {
        $this->nationality = $nationality;
    }

    // Métodos CRUD

    // Obtener todos los actores
    public function getAll() {
        $mysqli = $this->initConnectionDb();

        try {
            $query = $mysqli->query("SELECT * FROM actores ORDER BY id ASC");
        } catch (PDOException $e) {
            echo 'Error executing query: ' . $e->getMessage();  
        }
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Actor($item['id'], $item['nombre'], $item['apellidos'], $item['fecha_nacimiento'], $item['nacionalidad']);
            array_push($listData, $itemObject);            
        }
        return $listData;
    }

    // Crear un actor
    public function store() {
        $actorCreated = false;
        $mysqli = $this->initConnectionDb();

        // Verificar si ya existe un director con el mismo nombre y apellido
        $checkQuery = "SELECT * FROM actores WHERE nombre = '" . $this->name . "' AND apellidos = '" . $this->surname . "'";
        $result = $mysqli->query($checkQuery);
        
        if ($result->rowCount() > 0) {
                return false;
            }
        if ($resultInsert = $mysqli->query("INSERT INTO actores (nombre, apellidos, fecha_nacimiento, nacionalidad) VALUES (' $this->name ', '$this->surname', '$this->birth_date', '$this->nationality')")) {
            $actorCreated = true;
        }
        return $actorCreated;
    }

    // Editar un actor
    public function update() {
        $actorEdited = false;
        $mysqli = $this->initConnectionDb();

        // Verificar si ya existe un director con el mismo nombre y apellido
        $checkQuery = "SELECT * FROM actores WHERE nombre = '" . $this->name . "' AND apellidos = '" . $this->surname . "'";
        $result = $mysqli->query($checkQuery);
        
        if ($result->rowCount() > 0) {
            return false;
            }
            
        if ($query = $mysqli->query("UPDATE actores SET nombre = '$this->name', apellidos = '$this->surname', fecha_nacimiento = '$this->birth_date', nacionalidad = '$this->nationality' WHERE id =  $this->id")) {
            $actorEdited = true;
        }
        return $actorEdited;
    }

    // Obtener actor por id
    public function getItem() {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM actores WHERE id = " . $this->id);

        foreach ($query as $item) {
            $itemObject = new Actor($item["id"], $item["nombre"], $item['apellidos'], $item['fecha_nacimiento'], $item['nacionalidad']);
            break;
        }

        return $itemObject;
    }

    // Borrar un actor
    public function delete() {
        $actorDeleted = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que existe antes de borrar
        if ($query = $mysqli->query("DELETE FROM actores WHERE id =". $this->id)) {
            $actorDeleted = true;
        }

        return $actorDeleted;
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
