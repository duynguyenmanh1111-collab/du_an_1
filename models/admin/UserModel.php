<?php

class UserModel
{
    private $conn;
    private $table = 'users'; // Tên bảng trong database

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả tài khoản
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Lấy thông tin 1 tài khoản theo ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm tài khoản mới
    public function createUser($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, full_name, phone, role, password, status ) 
                  VALUES (:username, :email, :full_name, :phone ,:role , :password ,:status)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':full_name', $data['full_name']);
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':status', $data['status']);
        return $stmt->execute();
    }

    // Cập nhật thông tin tài khoản
    public function updateUser($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET username = :username,
                   phone = :phone, 
                      email = :email, 
                      full_name = :full_name, 
                      role = :role, 
                      status = :status";

        // Nếu có mật khẩu mới thì cập nhật
        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':role', $data['role']);

        if (!empty($data['password'])) {
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed_password);
        }

        return $stmt->execute();
    }

    // Xóa tài khoản
    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
