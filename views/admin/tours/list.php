<?php ob_start(); ?>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Tour</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>?act=tour-add" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Thêm Tour
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Lịch trình</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tours)): ?>
                <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                <?php else: ?>
                <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?= $tour['id'] ?></td>
                    <td><?= htmlspecialchars($tour['name']) ?></td>
                    <td><?= htmlspecialchars($tour['category_name'] ?? 'N/A') ?></td>
                    <td><?= number_format($tour['price'], 0, ',', '.') ?> VNĐ</td>
                    <td>
                        <span class="badge bg-<?= $tour['status'] === 'open' ? 'success' : 'secondary' ?>">
                            <?= $tour['status'] === 'open' ? 'Mở' : 'Đóng' ?>
                        </span>
                    </td>
                    <td>
                        <?php
                        $schedules = $tour['schedules'] ?? null;
                        if (is_string($schedules)) {
                            $schedules = json_decode($schedules, true) ?? [];
                        }
                        echo count($schedules) . ' ngày';
                        ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>?act=tour-edit&id=<?= $tour['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= BASE_URL ?>?act=tour-delete&id=<?= $tour['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
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
    'title' => $title ?? 'Quản lý Tour',
    'pageTitle' => 'Quản lý Tour',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Tour', 'url' => BASE_URL . '?act=tour-list', 'active' => true]
    ]
]);
?>
