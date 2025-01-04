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
            $itemObject = new Platform($item['id'], $item['name']);
            array_push($listData, $itemObject);

            $mysqli->close();

            return $listData;
        }
    }

    /*
    // Crear una nueva plataforma
    public function create() {
        $query = "INSERT INTO plataformas (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        return $stmt->execute();
    }


    // Obtener una plataforma por ID
    public function getById($id) {
        $query = "SELECT * FROM plataformas WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una plataforma
    public function update() {
        $query = "UPDATE plataformas SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Eliminar una plataforma
    public function delete($id) {
        $query = "DELETE FROM plataformas WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } */

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
