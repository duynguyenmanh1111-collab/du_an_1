<?php

class AdminCategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        requireAdmin();
        $categories = $this->categoryModel->getAll();
        view('admin.categories.list', [
            'title' => 'Danh mục Tour',
            'categories' => $categories,
        ]);
    }

    public function add()
    {
        requireAdmin();
        view('admin.categories.add', [
            'title' => 'Thêm danh mục',
        ]);
    }

    public function handleAdd()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=category-add');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = 'Tên danh mục không được để trống!';
            header('Location: ' . BASE_URL . '?act=category-add');
            exit;
        }

        $this->categoryModel->insert($name, $description);
        $_SESSION['success'] = 'Thêm danh mục thành công!';
        header('Location: ' . BASE_URL . '?act=category');
        exit;
    }

    public function edit()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '?act=category');
            exit;
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            $_SESSION['error'] = 'Danh mục không tồn tại!';
            header('Location: ' . BASE_URL . '?act=category');
            exit;
        }

        view('admin.categories.edit', [
            'title' => 'Sửa danh mục',
            'category' => $category,
        ]);
    }

    public function handleEdit()
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=category');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($name)) {
            $_SESSION['error'] = 'Tên danh mục không được để trống!';
            header('Location: ' . BASE_URL . '?act=category-edit&id=' . $id);
            exit;
        }

        $this->categoryModel->update($id, $name, $description);
        $_SESSION['success'] = 'Cập nhật danh mục thành công!';
        header('Location: ' . BASE_URL . '?act=category');
        exit;
    }

    public function delete()
    {
        requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->categoryModel->delete($id);
            $_SESSION['success'] = 'Xóa danh mục thành công!';
        }
        header('Location: ' . BASE_URL . '?act=category');
        exit;
    }
}
