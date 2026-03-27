<?php

class AdminGuideController
{
    private $guideModel;

    public function __construct()
    {
        $this->guideModel = new GuideModel();
    }

    public function index()
    {
        requireAdmin();
        $guides = $this->guideModel->getAll();
        view('admin.guides.list', [
            'title' => 'Quản lý Hướng dẫn viên',
            'guides' => $guides,
        ]);
    }

    public function create()
    {
        requireAdmin();
        $availableUsers = $this->guideModel->getAvailableUsers();
        view('admin.guides.create', [
            'title' => 'Thêm Hướng dẫn viên',
            'availableUsers' => $availableUsers,
        ]);
    }

    public function store()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin_guide_create');
            exit;
        }

        $data = [
            'user_id' => $_POST['user_id'] ?? null,
            'full_name' => trim($_POST['full_name'] ?? ''),
            'specialization' => trim($_POST['specialization'] ?? ''),
            'experience_years' => intval($_POST['experience_years'] ?? 0),
            'certificates' => trim($_POST['certificates'] ?? ''),
            'languages' => trim($_POST['languages'] ?? ''),
            'status' => $_POST['status'] ?? 'active',
        ];

        if (empty($data['full_name'])) {
            $_SESSION['error'] = 'Họ tên không được để trống!';
            header('Location: ' . BASE_URL . '?act=admin_guide_create');
            exit;
        }

        $this->guideModel->insert($data);
        $_SESSION['success'] = 'Thêm hướng dẫn viên thành công!';
        header('Location: ' . BASE_URL . '?act=admin_guides');
        exit;
    }

    public function edit()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=admin_guides');
            exit;
        }

        $guide = $this->guideModel->getById($id);
        if (!$guide) {
            $_SESSION['error'] = 'Hướng dẫn viên không tồn tại!';
            header('Location: ' . BASE_URL . '?act=admin_guides');
            exit;
        }

        $availableUsers = $this->guideModel->getAvailableUsers();

        view('admin.guides.edit', [
            'title' => 'Sửa Hướng dẫn viên',
            'guide' => $guide,
            'availableUsers' => $availableUsers,
        ]);
    }

    public function update()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin_guides');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=admin_guides');
            exit;
        }

        $data = [
            'user_id' => $_POST['user_id'] ?? null,
            'full_name' => trim($_POST['full_name'] ?? ''),
            'specialization' => trim($_POST['specialization'] ?? ''),
            'experience_years' => intval($_POST['experience_years'] ?? 0),
            'certificates' => trim($_POST['certificates'] ?? ''),
            'languages' => trim($_POST['languages'] ?? ''),
            'status' => $_POST['status'] ?? 'active',
        ];

        if (empty($data['full_name'])) {
            $_SESSION['error'] = 'Họ tên không được để trống!';
            header('Location: ' . BASE_URL . '?act=admin_guide_edit&id=' . $id);
            exit;
        }

        $this->guideModel->update($id, $data);
        $_SESSION['success'] = 'Cập nhật hướng dẫn viên thành công!';
        header('Location: ' . BASE_URL . '?act=admin_guides');
        exit;
    }

    public function delete()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->guideModel->delete($id);
            $_SESSION['success'] = 'Xóa hướng dẫn viên thành công!';
        }
        header('Location: ' . BASE_URL . '?act=admin_guides');
        exit;
    }
}
