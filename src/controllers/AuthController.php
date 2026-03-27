<?php

// Controller xử lý các chức năng liên quan đến xác thực (đăng nhập, đăng xuất)
class AuthController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    // Hiển thị form đăng nhập
    public function login()
    {
        // Nếu đã đăng nhập rồi thì chuyển về trang home
        if (isLoggedIn()) {
            header('Location: ' . BASE_URL . 'home');
            exit;
        }

        // Lấy URL redirect nếu có (để quay lại trang đang xem sau khi đăng nhập)
        // Mặc định redirect về trang home
        $redirect = $_GET['redirect'] ?? BASE_URL . 'home';

        // Hiển thị view login
        view('auth.login', [
            'title' => 'Đăng nhập',
            'redirect' => $redirect,
        ]);
    }

    // Xử lý đăng nhập (nhận dữ liệu từ form POST)
    public function checkLogin()
    {
        // Chỉ xử lý khi là POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Lấy dữ liệu từ form
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        // Mặc định redirect về trang home sau khi đăng nhập
        $redirect = $_POST['redirect'] ?? BASE_URL . 'home';

        // Validate dữ liệu đầu vào
        $errors = [];

        if (empty($email)) {
            $errors[] = 'Vui lòng nhập email';
        }

        if (empty($password)) {
            $errors[] = 'Vui lòng nhập mật khẩu';
        }

        // Nếu có lỗi validation thì quay lại form login
        if (!empty($errors)) {
            view('auth.login', [
                'title' => 'Đăng nhập',
                'errors' => $errors,
                'email' => $email,
                'redirect' => $redirect,
            ]);
            return;
        }

        // Xác thực user từ database
        $userData = $this->authModel->authenticate($email, $password);

        if (!$userData) {
            view('auth.login', [
                'title' => 'Đăng nhập',
                'errors' => ['Email hoặc mật khẩu không chính xác!'],
                'email' => $email,
                'redirect' => $redirect,
            ]);
            return;
        }

        // Tạo đối tượng User từ dữ liệu database
        $user = new User([
            'id' => $userData['id'],
            'name' => $userData['full_name'] ?? $userData['username'] ?? 'User',
            'email' => $userData['email'],
            'role' => $userData['role'],
            'status' => $userData['status'],
        ]);

        // Đăng nhập thành công: lưu vào session
        loginUser($user);

        // Lưu thêm thông tin user vào session để sử dụng
        $_SESSION['user'] = $userData;

        // Điều hướng dựa vào role
        if ($userData['role'] === 'admin') {
            header('Location: ' . BASE_URL . '?act=admin');
        } elseif ($userData['role'] === 'guide') {
            header('Location: ' . BASE_URL . '?act=guide');
        } else {
            header('Location: ' . $redirect);
        }
        exit;
    }

    // Xử lý đăng xuất
    public function logout()
    {
        // Xóa session và đăng xuất
        logoutUser();
        unset($_SESSION['user']);

        // Chuyển hướng về trang welcome
        header('Location: ' . BASE_URL . 'welcome');
        exit;
    }
}
