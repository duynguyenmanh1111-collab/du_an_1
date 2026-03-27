`<?php
class DestinationModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $sql = "SELECT * FROM destinations ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM destinations WHERE id = :id ";
        $stmt = $this->conn->prepare($sql);
       $stmt->execute([
    ':id' => $id
]);
        return $stmt->fetch();
    }

    public function insert($name, $description, $location) {
        $sql = "INSERT INTO destinations (name, description, location) VALUES (:name, :description, :location)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        return $stmt->execute();
    }

    public function update($id, $name, $description, $location) {
    $sql = "UPDATE destinations SET name=:name, description=:description, location=:location WHERE id=:id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}

    public function delete($id) {
        $sql = "DELETE FROM `destinations` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
