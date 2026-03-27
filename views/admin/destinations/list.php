<?php ob_start(); ?>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['error'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error']); endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách điểm đến</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>?act=destination-create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Thêm mới
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th>Tên điểm đến</th>
                        <th>Địa điểm</th>
                        <th>Mô tả</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($destinations)): ?>
                        <?php foreach ($destinations as $dest): ?>
                            <tr>
                                <td><?= $dest['id'] ?></td>
                                <td><?= htmlspecialchars($dest['name']) ?></td>
                                <td><?= htmlspecialchars($dest['location'] ?? '') ?></td>
                                <td><?= htmlspecialchars(mb_substr($dest['description'] ?? '', 0, 100)) ?>...</td>
                                <td>
                                    <a href="<?= BASE_URL ?>?act=destination-edit&id=<?= $dest['id'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>?act=destination-delete&id=<?= $dest['id'] ?>" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa điểm đến này?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Chưa có điểm đến nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Quản lý điểm đến',
    'pageTitle' => 'Quản lý điểm đến',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Điểm đến', 'active' => true]
    ]
]);
?>
