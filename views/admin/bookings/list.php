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
        <h3 class="card-title">Danh sách Booking</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>?act=bookings-add" class="btn btn-primary btn-sm">
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
                        <th>Tour</th>
                        <th>Hướng dẫn viên</th>
                        <th>Ngày đi</th>
                        <th>Ngày về</th>
                        <th>Số người</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <?php
                            $tour = !empty($booking['tour']) ? json_decode($booking['tour'], true) : [];
                            $guide = !empty($booking['guide']) ? json_decode($booking['guide'], true) : [];
                            ?>
                            <tr>
                                <td><?= $booking['id'] ?></td>
                                <td><?= htmlspecialchars($tour['name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($guide['full_name'] ?? 'Chưa có') ?></td>
                                <td><?= date('d/m/Y', strtotime($booking['start_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($booking['end_date'])) ?></td>
                                <td><?= $booking['max_people'] ?? 0 ?></td>
                                <td>
                                    <?php
                                    $statusClass = match($booking['status']) {
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                    $statusText = match($booking['status']) {
                                        'pending' => 'Chờ xác nhận',
                                        'confirmed' => 'Đang chạy',
                                        'completed' => 'Hoàn thành',
                                        'cancelled' => 'Đã hủy',
                                        default => $booking['status']
                                    };
                                    ?>
                                    <span class="badge bg-<?= $statusClass ?>"><?= $statusText ?></span>
                                </td>
                                <td>
                                    <?php
                                    $paymentClass = match($booking['payment_status'] ?? 'unpaid') {
                                        'paid' => 'success',
                                        'partial' => 'warning',
                                        'unpaid' => 'danger',
                                        default => 'secondary'
                                    };
                                    $paymentText = match($booking['payment_status'] ?? 'unpaid') {
                                        'paid' => 'Đã TT',
                                        'partial' => 'TT 1 phần',
                                        'unpaid' => 'Chưa TT',
                                        default => $booking['payment_status']
                                    };
                                    ?>
                                    <span class="badge bg-<?= $paymentClass ?>"><?= $paymentText ?></span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>?act=bookings-detail&id=<?= $booking['id'] ?>" class="btn btn-info btn-sm" title="Chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>?act=bookings-edit&id=<?= $booking['id'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>?act=bookings-delete&id=<?= $booking['id'] ?>" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Chưa có booking nào</td>
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
    'title' => $title ?? 'Quản lý Booking',
    'pageTitle' => 'Quản lý Booking',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Booking', 'active' => true]
    ]
]);
?>
