<?php ob_start(); ?>

<?php
$tour = !empty($booking['tour']) ? json_decode($booking['tour'], true) : [];
$guide = !empty($booking['guide']) ? json_decode($booking['guide'], true) : [];
$destination = !empty($booking['destination']) ? json_decode($booking['destination'], true) : [];
$transports = !empty($booking['transports']) ? json_decode($booking['transports'], true) : [];
$accommodations = !empty($booking['accommodations']) ? json_decode($booking['accommodations'], true) : [];
$people = !empty($booking['people']) ? json_decode($booking['people'], true) : [];
$schedules = !empty($booking['schedules']) ? json_decode($booking['schedules'], true) : [];
?>

<div class="row">
    <!-- Thông tin chính -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-info-circle"></i> Thông tin Booking #<?= $booking['id'] ?></h3>
                <div class="card-tools">
                    <a href="<?= BASE_URL ?>?act=bookings-edit&id=<?= $booking['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tour:</strong> <?= htmlspecialchars($tour['name'] ?? 'N/A') ?></p>
                        <p><strong>Điểm đến:</strong> <?= htmlspecialchars($destination['name'] ?? 'N/A') ?></p>
                        <p><strong>Ngày đi:</strong> <?= date('d/m/Y', strtotime($booking['start_date'])) ?></p>
                        <p><strong>Ngày về:</strong> <?= date('d/m/Y', strtotime($booking['end_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Hướng dẫn viên:</strong> <?= htmlspecialchars($guide['full_name'] ?? 'Chưa có') ?></p>
                        <p><strong>Số người:</strong> <?= $seats['current_people'] ?? 0 ?> / <?= $booking['max_people'] ?? 0 ?></p>
                        <p><strong>Trạng thái:</strong>
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
                        </p>
                        <p><strong>Thanh toán:</strong>
                            <?php
                            $paymentClass = match($booking['payment_status'] ?? 'unpaid') {
                                'paid' => 'success',
                                'partial' => 'warning',
                                'unpaid' => 'danger',
                                default => 'secondary'
                            };
                            $paymentText = match($booking['payment_status'] ?? 'unpaid') {
                                'paid' => 'Đã thanh toán',
                                'partial' => 'Thanh toán 1 phần',
                                'unpaid' => 'Chưa thanh toán',
                                default => $booking['payment_status']
                            };
                            ?>
                            <span class="badge bg-<?= $paymentClass ?>"><?= $paymentText ?></span>
                        </p>
                    </div>
                </div>
                <?php if (!empty($booking['special_request'])): ?>
                <div class="mt-3">
                    <strong>Yêu cầu đặc biệt:</strong>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($booking['special_request'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Danh sách khách -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-people"></i> Danh sách khách (<?= count($people) ?>)</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>SĐT</th>
                            <th>CCCD</th>
                            <th>Giới tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($people)): ?>
                            <?php foreach ($people as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($p['fullname'] ?? '') ?></td>
                                <td><?= htmlspecialchars($p['phone'] ?? '') ?></td>
                                <td><?= htmlspecialchars($p['cccd'] ?? '') ?></td>
                                <td><?= ($p['gender'] ?? '') == 'male' ? 'Nam' : 'Nữ' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted">Chưa có khách</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Điểm danh -->
        <?php if (!empty($attendanceSummary)): ?>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-clipboard-check"></i> Điểm danh theo ngày</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ngày</th>
                            <th>Có mặt</th>
                            <th>Vắng mặt</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendanceSummary as $summary): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($summary['date'])) ?></td>
                            <td><span class="badge bg-success"><?= $summary['present'] ?? 0 ?></span></td>
                            <td><span class="badge bg-danger"><?= $summary['absent'] ?? 0 ?></span></td>
                            <td><?= $summary['total'] ?? 0 ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Phương tiện -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-truck"></i> Phương tiện</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($transports)): ?>
                    <?php foreach ($transports as $transport): ?>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <div>
                            <strong><?= htmlspecialchars(ucfirst($transport['type'] ?? '')) ?></strong><br>
                            <small class="text-muted"><?= htmlspecialchars($transport['company'] ?? '') ?></small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-secondary"><?= $transport['seats'] ?? 0 ?> chỗ</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Chưa có phương tiện</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lưu trú -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-building"></i> Nơi lưu trú</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($accommodations)): ?>
                    <?php foreach ($accommodations as $accommodation): ?>
                    <div class="border-bottom py-2">
                        <strong><?= htmlspecialchars($accommodation['name'] ?? '') ?></strong><br>
                        <small class="text-muted">
                            <?= htmlspecialchars($accommodation['type'] ?? '') ?> -
                            <?= htmlspecialchars($accommodation['address'] ?? '') ?>
                        </small>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Chưa có nơi lưu trú</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lịch trình -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-calendar-event"></i> Lịch trình</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($schedules)): ?>
                    <?php foreach ($schedules as $schedule): ?>
                    <div class="border-bottom py-2">
                        <strong>Ngày <?= $schedule['day_number'] ?? '' ?></strong><br>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($schedule['location'] ?? '') ?><br>
                            <?= htmlspecialchars($schedule['activities'] ?? '') ?>
                        </small>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Chưa có lịch trình</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= BASE_URL ?>?act=bookings" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Chi tiết Booking',
    'pageTitle' => 'Chi tiết Booking #' . $booking['id'],
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Booking', 'url' => BASE_URL . '?act=bookings'],
        ['label' => 'Chi tiết', 'active' => true]
    ]
]);
?>
