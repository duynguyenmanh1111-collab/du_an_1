<?php

/**
 * AuthModel - Xử lý authentication
 */
class AuthModel
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $this->conn = getDB();
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Xác thực đăng nhập
     * @return array|false - Trả về user data nếu thành công, false nếu thất bại
     */
    public function authenticate($email, $password)
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        // Kiểm tra mật khẩu
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Kiểm tra trạng thái tài khoản
        if ($user['status'] !== 'active') {
            return false;
        }

        return $user;
    }
}
