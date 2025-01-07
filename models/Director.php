<?php

class Director {
    private $id;
    private $name;
    private $surname;
    private $birth_date;
    private $nationality;

    // Constructores
    public function __construct($idDirector, $nameDirector, $surnameDirector, $birth_date_Director, $nationalityDirector) {
        $this->id = $idDirector;
        $this->name = $nameDirector;
        $this->surname = $surnameDirector;
        $this->birth_date = $birth_date_Director;
        $this->nationality = $nationalityDirector;
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
        return $this->birth_date;
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

    // Obtener todos los directores
    public function getAll() {
        $mysqli = $this->initConnectionDb();

        try {
            $query = $mysqli->query("SELECT * FROM directores ORDER BY id ASC");
        } catch (PDOException $e) {
            echo 'Error executing query: ' . $e->getMessage();  
        }
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Director($item['id'], $item['nombre'], $item['apellidos'], $item['fecha_nacimiento'], $item['nacionalidad']);
            array_push($listData, $itemObject);            
        }
        return $listData;
    }

    //Crear un director
    public function store() {
        $directorCreated = false;
        $mysqli = $this->initConnectionDb();
    
        $id = $mysqli->real_escape_string($this->id);
        $name = $mysqli->real_escape_string($this->name);
        $surname = $mysqli->real_escape_string($this->surname);
        $birth_date = $mysqli->real_escape_string($this->birth_date);
        $nationality = $mysqli->real_escape_string($this->nationality);
    
        $query = "INSERT INTO directores (id, name, surname, birth_date, nationality) 
          VALUES ('" . $id . "', '" . $name . "', '" . $surname . "', '" . $birth_date . "', '" . $nationality . "')";

        if ($mysqli->query($query)) {
            $directorCreated = true;
        }
    
        return $directorCreated;
    }

    // Editar una plataforma
    public function update() {
        $directorEdited = false;
        $mysqli = $this->initConnectionDb();

        $name = $mysqli->real_escape_string($this->name);
        $surname = $mysqli->real_escape_string($this->surname);
        $birth_date = $mysqli->real_escape_string($this->birth_date);
        $nationality = $mysqli->real_escape_string($this->nationality);

        // TODO: Comprobar que existe antes de editar
        $query = "UPDATE directores 
                  SET name = '" . $name . "', surname = '" . $surname . "', birth_date = '" . $birth_date . "', nationality = '" . $nationality . "' 
                  WHERE id = '" . $this->id . "'";
        
        if ($$mysqli->query($query)){
            $directorEdited = true;
        }
        return $directorEdited;
    }

    // Obtener director por id
    public function getItem() {
        $mysqli = $this->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM directores WHERE id = " . $this->id);

        foreach ($query as $item) {
            $itemObject = new Director($item["id"], $item["name"], $item["surname"], $item["birth_date"], $item["nationality"]);
            break;
        }

        return $itemObject;
    }

    // Borrar un director
    public function delete() {
        $directorDeleted = false;
        $mysqli = $this->initConnectionDb();

        // TODO: Comprobar que existe antes de borrar
        if ($query = $mysqli->query("DELETE FROM plataformas WHERE id =". $this->id)) {
            $directorDeleted = true;
        }

        return $directorDeleted;
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