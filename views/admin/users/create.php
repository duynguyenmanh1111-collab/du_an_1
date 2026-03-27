<?php ob_start(); ?>

<?php if (isset($_SESSION['errors'])): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach ($_SESSION['errors'] as $error): ?>
        <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php unset($_SESSION['errors']); endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm User mới</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=user-store" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="<?= $_SESSION['old']['username'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= $_SESSION['old']['email'] ?? '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                        <small class="text-muted">Ít nhất 6 ký tự</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" value="<?= $_SESSION['old']['full_name'] ?? '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="<?= $_SESSION['old']['phone'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Vai trò</label>
                        <select name="role" class="form-select">
                            <option value="guide">Hướng dẫn viên</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Khóa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            <a href="<?= BASE_URL ?>?act=admin-list-user" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php unset($_SESSION['old']); ?>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Thêm User',
    'pageTitle' => 'Thêm User mới',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'User', 'url' => BASE_URL . '?act=admin-list-user'],
        ['label' => 'Thêm mới', 'active' => true]
    ]
]);
?>
