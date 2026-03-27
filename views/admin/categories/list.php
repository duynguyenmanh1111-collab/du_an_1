<?php ob_start(); ?>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh mục Tour</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>?act=category-add" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Thêm danh mục
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                <tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>
                <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars($cat['description'] ?? '') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>?act=category-edit&id=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= BASE_URL ?>?act=category-delete&id=<?= $cat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title,
    'pageTitle' => 'Danh mục Tour',
    'content' => $content,
    'breadcrumb' => [['label' => 'Danh mục', 'active' => true]]
]);
?>
