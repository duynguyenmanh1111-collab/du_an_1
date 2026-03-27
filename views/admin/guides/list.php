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
        <h3 class="card-title">Danh sách hướng dẫn viên</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>?act=admin_guide_create" class="btn btn-primary btn-sm">
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
                        <th>Họ tên</th>
                        <th>Chuyên môn</th>
                        <th>Kinh nghiệm</th>
                        <th>Ngôn ngữ</th>
                        <th>Trạng thái</th>
                        <th width="120">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($guides)): ?>
                        <?php foreach ($guides as $guide): ?>
                            <tr>
                                <td><?= $guide['id'] ?></td>
                                <td><?= htmlspecialchars($guide['full_name']) ?></td>
                                <td><?= htmlspecialchars($guide['specialization'] ?? '') ?></td>
                                <td><?= $guide['experience_years'] ?? 0 ?> năm</td>
                                <td><?= htmlspecialchars($guide['languages'] ?? '') ?></td>
                                <td>
                                    <?php
                                    $statusClass = match($guide['status'] ?? 'active') {
                                        'active', 'available' => 'success',
                                        'inactive', 'busy' => 'warning',
                                        default => 'secondary'
                                    };
                                    $statusText = match($guide['status'] ?? 'active') {
                                        'active' => 'Hoạt động',
                                        'available' => 'Sẵn sàng',
                                        'inactive' => 'Tạm nghỉ',
                                        'busy' => 'Đang bận',
                                        default => $guide['status']
                                    };
                                    ?>
                                    <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>?act=admin_guide_edit&id=<?= $guide['id'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>?act=admin_guide_delete&id=<?= $guide['id'] ?>" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa hướng dẫn viên này?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Chưa có hướng dẫn viên nào</td>
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
    'title' => $title ?? 'Quản lý HDV',
    'pageTitle' => 'Quản lý hướng dẫn viên',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Hướng dẫn viên', 'active' => true]
    ]
]);
?>
