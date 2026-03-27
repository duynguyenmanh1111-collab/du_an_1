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

<?php
$tour = !empty($booking['tour']) ? json_decode($booking['tour'], true) : [];
$guide = !empty($booking['guide']) ? json_decode($booking['guide'], true) : [];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Booking #<?= $booking['id'] ?></h3>
    </div>
    <form action="<?= BASE_URL ?>?act=bookings-update" method="POST">
        <input type="hidden" name="id" value="<?= $booking['id'] ?>">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tour <span class="text-danger">*</span></label>
                        <select name="tour_id" class="form-select" required>
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($tours as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= ($booking['tour_id'] ?? '') == $t['id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Hướng dẫn viên</label>
                        <select name="guide_id" class="form-select">
                            <option value="">-- Chọn HDV --</option>
                            <?php foreach ($guides as $g): ?>
                            <option value="<?= $g['id'] ?>" <?= ($booking['guide_id'] ?? '') == $g['id'] ? 'selected' : '' ?>><?= htmlspecialchars($g['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="<?= $booking['start_date'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" value="<?= $booking['end_date'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Số người tối đa</label>
                        <input type="number" name="max_people" class="form-control" value="<?= $booking['max_people'] ?? 10 ?>" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Số người hiện tại</label>
                        <span class="form-control bg-light"><?= $seats['current_people'] ?? 0 ?> / <?= $booking['max_people'] ?? 10 ?></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?= ($booking['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Chờ xác nhận</option>
                            <option value="confirmed" <?= ($booking['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Đang chạy</option>
                            <option value="completed" <?= ($booking['status'] ?? '') == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="cancelled" <?= ($booking['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thanh toán</label>
                        <select name="payment_status" class="form-select">
                            <option value="unpaid" <?= ($booking['payment_status'] ?? '') == 'unpaid' ? 'selected' : '' ?>>Chưa thanh toán</option>
                            <option value="partial" <?= ($booking['payment_status'] ?? '') == 'partial' ? 'selected' : '' ?>>Thanh toán 1 phần</option>
                            <option value="paid" <?= ($booking['payment_status'] ?? '') == 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Yêu cầu đặc biệt</label>
                <textarea name="special_request" class="form-control" rows="2"><?= htmlspecialchars($booking['special_request'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <a href="<?= BASE_URL ?>?act=bookings-detail&id=<?= $booking['id'] ?>" class="btn btn-info">Chi tiết</a>
            <a href="<?= BASE_URL ?>?act=bookings" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Sửa Booking',
    'pageTitle' => 'Sửa Booking #' . $booking['id'],
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Booking', 'url' => BASE_URL . '?act=bookings'],
        ['label' => 'Sửa', 'active' => true]
    ]
]);
?>
