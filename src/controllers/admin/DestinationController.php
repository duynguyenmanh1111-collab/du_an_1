<?php

class AdminDestinationController
{
    private $destinationModel;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
    }

    public function index()
    {
        requireAdmin();
        $destinations = $this->destinationModel->getAll();
        view('admin.destinations.list', [
            'title' => 'Điểm đến',
            'destinations' => $destinations,
        ]);
    }

    public function create()
    {
        requireAdmin();
        view('admin.destinations.add', [
            'title' => 'Thêm điểm đến',
        ]);
    }

    public function store()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=destination-create');
            exit;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
        ];

        if (empty($data['name'])) {
            $_SESSION['error'] = 'Tên điểm đến không được để trống!';
            header('Location: ' . BASE_URL . '?act=destination-create');
            exit;
        }

        $this->destinationModel->insert($data['name'], $data['description'], $data['location']);
        $_SESSION['success'] = 'Thêm điểm đến thành công!';
        header('Location: ' . BASE_URL . '?act=destination-index');
        exit;
    }

    public function edit()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=destination-index');
            exit;
        }

        $destination = $this->destinationModel->getOne($id);
        if (!$destination) {
            $_SESSION['error'] = 'Điểm đến không tồn tại!';
            header('Location: ' . BASE_URL . '?act=destination-index');
            exit;
        }

        view('admin.destinations.edit', [
            'title' => 'Sửa điểm đến',
            'destination' => $destination,
        ]);
    }

    public function update()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=destination-index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
        ];

        if (empty($data['name'])) {
            $_SESSION['error'] = 'Tên điểm đến không được để trống!';
            header('Location: ' . BASE_URL . '?act=destination-edit&id=' . $id);
            exit;
        }

        $this->destinationModel->update($id, $data['name'], $data['description'], $data['location']);
        $_SESSION['success'] = 'Cập nhật điểm đến thành công!';
        header('Location: ' . BASE_URL . '?act=destination-index');
        exit;
    }

    public function delete()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->destinationModel->delete($id);
            $_SESSION['success'] = 'Xóa điểm đến thành công!';
        }
        header('Location: ' . BASE_URL . '?act=destination-index');
        exit;
    }
}
