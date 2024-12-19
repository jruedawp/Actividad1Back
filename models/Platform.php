<?php

class Platform {
    private $id;
    private $name;
    private $db;

    // Constructor
    public function __construct($db) {
        $this->db = $db; // Conexión a la base de datos
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

    // Crear una nueva plataforma
    public function create() {
        $query = "INSERT INTO plataformas (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        return $stmt->execute();
    }

    // Obtener todas las plataformas
    public function getAll() {
        $query = "SELECT * FROM plataformas";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    }
}

?>
