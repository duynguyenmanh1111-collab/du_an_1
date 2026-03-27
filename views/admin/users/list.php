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
        <h3 class="card-title">Danh sách User</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>?act=user-create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Thêm User
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Họ tên</th>
                    <th>Vai trò</th>
                    <th>SĐT</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>
                <?php else: ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['full_name'] ?? '') ?></td>
                    <td>
                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                            <?= $user['role'] === 'admin' ? 'Admin' : 'Hướng dẫn viên' ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                    <td>
                        <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'secondary' ?>">
                            <?= $user['status'] === 'active' ? 'Hoạt động' : 'Khóa' ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>?act=admin-edit-user&id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= BASE_URL ?>?act=user-delete&id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
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
    'title' => $title ?? 'Quản lý User',
    'pageTitle' => 'Quản lý User',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'User', 'url' => BASE_URL . '?act=admin-list-user', 'active' => true]
    ]
]);
?>
