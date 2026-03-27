<?php

class TourModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function findEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE email = :email");
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Viết truy vấn lấy dữ liệu cho trang chủ
    public function getHomeData()
    {
        // Ví dụ: Lấy danh sách sản phẩm nổi bật
        $sql = "SELECT * FROM products WHERE featured = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteTour($id)
    {
        $sql = "DELETE FROM `tours` WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
