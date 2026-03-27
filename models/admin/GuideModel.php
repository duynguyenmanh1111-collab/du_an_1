<?php

class GuideModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB(); // Hàm có sẵn trong function.php
    }

    public function getAll()
    {
        $sql = "SELECT * FROM guides ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableUsers() {
        $sql = "SELECT id, username, full_name, email 
              FROM users 
              WHERE role = 'guide'
              ORDER BY full_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM guides WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $sql = "INSERT INTO guides (full_name, specialization, experience_years, certificates, languages, status, user_id)
                VALUES (:full_name, :specialization, :experience_years, :certificates, :languages, :status, :user_id)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':specialization' => $data['specialization'],
            ':experience_years' => $data['experience_years'],
            ':certificates' => $data['certificates'],
            ':languages' => $data['languages'],
            ':status' => $data['status'],
            ':user_id' => $data['user_id']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE guides SET 
                    full_name = :full_name,
                    specialization = :specialization,
                    experience_years = :experience_years,
                    certificates = :certificates,
                    languages = :languages,
                    status = :status,
                    user_id = :user_id
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':specialization' => $data['specialization'],
            ':experience_years' => $data['experience_years'],
            ':certificates' => $data['certificates'],
            ':languages' => $data['languages'],
            ':status' => $data['status'],
            ':user_id' => $data['user_id'],
            ':id' => $id
        ]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM guides WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
