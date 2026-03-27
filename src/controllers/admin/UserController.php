<?php

class AdminUserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        requireAdmin();
        $users = $this->userModel->getAllUsers();
        view('admin.users.list', [
            'title' => 'Quản lý User',
            'users' => $users,
        ]);
    }

    public function create()
    {
        requireAdmin();
        view('admin.users.create', [
            'title' => 'Thêm User mới',
        ]);
    }

    public function store()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=user-create');
            exit;
        }

        $errors = [];
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'role' => $_POST['role'] ?? 'guide',
            'status' => $_POST['status'] ?? 'active',
        ];

        if (empty($data['username'])) $errors[] = 'Username không được để trống';
        if (empty($data['email'])) $errors[] = 'Email không được để trống';
        if (empty($data['password'])) $errors[] = 'Mật khẩu không được để trống';
        if (strlen($data['password']) < 6) $errors[] = 'Mật khẩu ít nhất 6 ký tự';
        if (empty($data['full_name'])) $errors[] = 'Họ tên không được để trống';
        if ($this->userModel->emailExists($data['email'])) $errors[] = 'Email đã tồn tại';
        if ($this->userModel->usernameExists($data['username'])) $errors[] = 'Username đã tồn tại';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            header('Location: ' . BASE_URL . '?act=user-create');
            exit;
        }

        $this->userModel->createUser($data);
        $_SESSION['success'] = 'Thêm user thành công!';
        header('Location: ' . BASE_URL . '?act=admin-list-user');
        exit;
    }

    public function edit()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=admin-list-user');
            exit;
        }

        $user = $this->userModel->getUserById($id);
        if (!$user) {
            $_SESSION['error'] = 'User không tồn tại!';
            header('Location: ' . BASE_URL . '?act=admin-list-user');
            exit;
        }

        view('admin.users.edit', [
            'title' => 'Sửa User',
            'user' => $user,
        ]);
    }

    public function update()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-list-user');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=admin-list-user');
            exit;
        }

        $errors = [];
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'full_name' => trim($_POST['full_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'role' => $_POST['role'] ?? 'guide',
            'status' => $_POST['status'] ?? 'active',
        ];

        if (empty($data['username'])) $errors[] = 'Username không được để trống';
        if (empty($data['email'])) $errors[] = 'Email không được để trống';
        if (!empty($data['password']) && strlen($data['password']) < 6) $errors[] = 'Mật khẩu ít nhất 6 ký tự';
        if (empty($data['full_name'])) $errors[] = 'Họ tên không được để trống';
        if ($this->userModel->emailExists($data['email'], $id)) $errors[] = 'Email đã tồn tại';
        if ($this->userModel->usernameExists($data['username'], $id)) $errors[] = 'Username đã tồn tại';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . '?act=admin-edit-user&id=' . $id);
            exit;
        }

        $this->userModel->updateUser($id, $data);
        $_SESSION['success'] = 'Cập nhật user thành công!';
        header('Location: ' . BASE_URL . '?act=admin-list-user');
        exit;
    }

    public function delete()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->userModel->deleteUser($id);
            $_SESSION['success'] = 'Xóa user thành công!';
        }
        header('Location: ' . BASE_URL . '?act=admin-list-user');
        exit;
    }

    public function myAccount()
    {
        requireAdmin();
        $userId = $_SESSION['user_id'] ?? null;
        $user = $this->userModel->getUserById($userId);

        view('admin.users.myaccount', [
            'title' => 'Tài khoản của tôi',
            'user' => $user,
        ]);
    }
}
