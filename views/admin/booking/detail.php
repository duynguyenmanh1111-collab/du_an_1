<?php
require_once __DIR__ . '/../../layout/admin/header.php';

// Giải mã JSON an toàn cho booking detail
if (!empty($booking)) {
    $booking['destination'] = !empty($booking['destination']) ? json_decode($booking['destination'], true) : [];
    $booking['transports'] = !empty($booking['transports']) ? json_decode($booking['transports'], true) : [];
    $booking['accommodations'] = !empty($booking['accommodations']) ? json_decode($booking['accommodations'], true) : [];
    $booking['schedules'] = !empty($booking['schedules']) ? json_decode($booking['schedules'], true) : [];
    $booking['tour'] = !empty($booking['tour']) ? json_decode($booking['tour'], true) : [];
    $booking['customer'] = !empty($booking['customer']) ? json_decode($booking['customer'], true) : [];
    $booking['people'] = !empty($booking['people']) ? json_decode($booking['people'], true) : [];
    $booking['category'] = !empty($booking['category']) ? json_decode($booking['category'], true) : [];
    $booking['guide'] = !empty($booking['guide']) ? json_decode($booking['guide'], true) : [];
    $booking['user'] = !empty($booking['user']) ? json_decode($booking['user'], true) : [];
}
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="booking-detail">
            <!-- HEADER BUTTONS -->
            <div class="action-buttons">
                <a href="index.php?act=bookings-list" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Quay lại danh sách
                </a>
                <a href="index.php?act=bookings-edit&id=<?= $booking['id'] ?>" class="btn btn-primary">
                    <i class="fa fa-edit"></i> Chỉnh sửa
                </a>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fa fa-print"></i> In chi tiết
                </button>
            </div>

            <h2 class="page-title">
                <i class="fa fa-file-text-o"></i>
                Chi Tiết Booking #<?= htmlspecialchars($booking['id']) ?>
                <span class="status-badge status-<?= $booking['status'] ?>">
                    <?php
                    if ($booking['status'] == 'pending') echo ' Chờ khởi hành';
                    elseif ($booking['status'] == 'confirmed') echo 'Đang khởi hành';
                    elseif ($booking['status'] == 'cancelled') echo 'Đã hủy';
                    elseif ($booking['status'] == 'completed') echo 'Hoàn thành';
                    else echo $booking['status'];
                    ?>
                </span>
            </h2>

            <!-- THÔNG TIN CHUNG -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4><i class="fa fa-info-circle"></i> Thông tin chung</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-icon bg-primary">
                                    <i class="fa fa-hashtag"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Mã Booking</span>
                                    <span class="info-value">#<?= htmlspecialchars($booking['id']) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-icon bg-success">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Số lượng</span>
                                    <span class="info-value"><?= $booking['number_of_people'] ?? 0 ?> người</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-icon bg-warning">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Ngày bắt đầu</span>
                                    <span class="info-value"><?= date('d/m/Y', strtotime($booking['start_date'])) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <div class="info-icon bg-danger">
                                    <i class="fa fa-calendar-check-o"></i>
                                </div>
                                <div class="info-content">
                                    <span class="info-label">Ngày kết thúc</span>
                                    <span class="info-value"><?= date('d/m/Y', strtotime($booking['end_date'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <!-- <div class="col-md-6">
                            <div class="info-group">
                                <label><i class="fa fa-check-circle"></i> Trạng thái thanh toán:</label>
                                <p>
                                    <span class="label label-<?= $booking['payment_status'] == 'paid' ? 'success' : 'warning' ?>" style="font-size: 13px; padding: 6px 12px;">
                                        <?= $booking['payment_status'] == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                    </span>
                                </p>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="info-group">
                                <label><i class="fa fa-clock-o"></i> Cập nhật lần cuối:</label>
                                <p><?= date('d/m/Y H:i:s', strtotime($booking['updated_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- THÔNG TIN TOUR -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><i class="fa fa-suitcase"></i> Thông tin Tour</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="info-group">
                                <label><i class="fa fa-tag"></i> Tên Tour:</label>
                                <p class="tour-name"><?= htmlspecialchars($booking['tour']['name'] ?? 'Chưa có tên tour') ?></p>
                            </div>
                            <div class="info-group">
                                <label><i class="fa fa-folder-open"></i> Danh mục:</label>
                                <p>
                                    <span class="badge badge-info" style="font-size: 13px; padding: 6px 12px; background: #5bc0de;">
                                        <?= htmlspecialchars($booking['category']['name'] ?? 'Chưa phân loại') ?>
                                    </span>
                                </p>
                            </div>
                            <?php if (!empty($booking['tour']['description'])): ?>
                                <div class="info-group">
                                    <label><i class="fa fa-align-left"></i> Mô tả:</label>
                                    <p style="line-height: 1.8;"><?= nl2br(htmlspecialchars($booking['tour']['description'])) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <div class="price-summary">
                                <div class="price-item">
                                    <span class="price-label">Giá tour / người</span>
                                    <span class="price-value price-per-person">
                                        <?= isset($booking['tour']['price']) ? number_format($booking['tour']['price'], 0, ',', '.') . ' VNĐ' : 'N/A' ?>
                                    </span>
                                </div>
                                <div class="price-item">
                                    <span class="price-label">Số lượng người</span>
                                    <span class="price-value">× <?= $booking['number_of_people'] ?? 0 ?></span>
                                </div>
                                <hr style="margin: 15px 0; border-color: #ddd;">
                                <div class="price-item total">
                                    <span class="price-label">TỔNG CỘNG</span>
                                    <span class="price-value price-total">
                                        <?php
                                        $total = ($booking['tour']['price'] ?? 0) * ($booking['number_of_people'] ?? 0);
                                        echo number_format($total, 0, ',', '.') . ' VNĐ';
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- YÊU CẦU ĐẶC BIỆT -->
            <?php if (!empty($booking['special_request'])): ?>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4><i class="fa fa-comment"></i> Yêu cầu đặc biệt</h4>
                    </div>
                    <div class="panel-body">
                        <div class="special-request-content">
                            <i class="fa fa-quote-left"></i>
                            <p><?= nl2br(htmlspecialchars($booking['special_request'])) ?></p>
                            <i class="fa fa-quote-right"></i>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ĐIỂM ĐẾN -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4><i class="fa fa-map-marker"></i> Điểm đến</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['destination'])): ?>
                        <div class="destination-info">
                            <div class="info-group">
                                <label><i class="fa fa-map-signs"></i> Tên điểm đến:</label>
                                <p class="destination-name"><?= htmlspecialchars($booking['destination']['name'] ?? 'Không có tên') ?></p>
                            </div>
                            <div class="info-group">
                                <label><i class="fa fa-globe"></i> Địa điểm:</label>
                                <p><?= htmlspecialchars($booking['destination']['location'] ?? 'Không có địa điểm') ?></p>
                            </div>
                            <div class="info-group">
                                <label><i class="fa fa-info-circle"></i> Mô tả:</label>
                                <p style="line-height: 1.8;"><?= nl2br(htmlspecialchars($booking['destination']['description'] ?? 'Chưa có mô tả')) ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Chưa có thông tin điểm đến</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- HƯỚNG DẪN VIÊN -->
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4><i class="fa fa-user-circle"></i> Hướng dẫn viên</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['guide']) && is_array($booking['guide'])): ?>
                        <div class="guide-card">
                            <div class="guide-avatar">
                                <i class="fa fa-user-circle-o"></i>
                            </div>
                            <div class="guide-details">
                                <h4 class="guide-name"><?= htmlspecialchars($booking['guide']['full_name'] ?? 'Chưa có tên') ?></h4>
                                <div class="guide-contact">
                                    <div class="contact-item">
                                        <i class="fa fa-envelope"></i>
                                        <span><?= htmlspecialchars($booking['user']['email'] ?? 'Chưa có email') ?></span>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fa fa-phone"></i>
                                        <span><?= htmlspecialchars($booking['user']['phone'] ?? 'Chưa có SĐT') ?></span>
                                    </div>
                                </div>
                                <?php if (!empty($booking['guide']['specialization'])): ?>
                                    <div class="guide-info">
                                        <span class="badge badge-warning">
                                            <i class="fa fa-star"></i> <?= htmlspecialchars($booking['guide']['specialization']) ?>
                                        </span>
                                        <?php if (!empty($booking['guide']['experience_years'])): ?>
                                            <span class="badge badge-info">
                                                <i class="fa fa-calendar"></i> <?= $booking['guide']['experience_years'] ?> năm kinh nghiệm
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Chưa có thông tin hướng dẫn viên</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- PHƯƠNG TIỆN -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4><i class="fa fa-bus"></i> Phương tiện di chuyển</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['transports'])): ?>
                        <div class="row">
                            <?php foreach ($booking['transports'] as $index => $transport): ?>
                                <div class="col-md-6">
                                    <div class="transport-card">
                                        <div class="transport-header">
                                            <i class="fa fa-bus"></i>
                                            <h5>Phương tiện <?= $index + 1 ?></h5>
                                        </div>

                                        <div class="transport-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="info-group-sm">
                                                        <label><i class="fa fa-car"></i> Loại xe:</label>
                                                        <p><?= htmlspecialchars($transport['type'] ?? 'N/A') ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="info-group-sm">
                                                        <label><i class="fa fa-users"></i> Số chỗ:</label>
                                                        <p><strong><?= $transport['seats'] ?? 'N/A' ?> chỗ</strong></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="info-group-sm">
                                                        <label><i class="fa fa-building"></i> Công ty:</label>
                                                        <p><?= htmlspecialchars($transport['company'] ?? 'N/A') ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="info-group-sm">
                                                        <label><i class="fa fa-id-card"></i> Biển số:</label>
                                                        <p><strong style="color: #337ab7;"><?= htmlspecialchars($transport['license_plate'] ?? 'N/A') ?></strong></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ĐIỂM ĐÓN KHÁCH -->
                                            <div class="pickup-section">
                                                <h6><i class="fa fa-map-marker"></i> Điểm đón khách</h6>
                                                <div class="info-group-sm">
                                                    <label>Địa điểm:</label>
                                                    <p><strong><?= htmlspecialchars($transport['pickup_location'] ?? 'N/A') ?></strong></p>
                                                </div>
                                                <?php if (!empty($transport['pickup_address'])): ?>
                                                    <div class="info-group-sm">
                                                        <label>Địa chỉ chi tiết:</label>
                                                        <p><?= htmlspecialchars($transport['pickup_address']) ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="info-group-sm">
                                                    <label>Giờ khởi hành:</label>
                                                    <p>
                                                        <span class="time-badge">
                                                            <i class="fa fa-clock-o"></i>
                                                            <?= !empty($transport['pickup_time']) ? substr($transport['pickup_time'], 0, 5) : 'N/A' ?>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- THÔNG TIN TÀI XẾ -->
                                            <div class="driver-section">
                                                <h6><i class="fa fa-user"></i> Thông tin tài xế</h6>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="info-group-sm">
                                                            <label>Họ tên:</label>
                                                            <p><?= htmlspecialchars($transport['driver_name'] ?? 'N/A') ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="info-group-sm">
                                                            <label>SĐT:</label>
                                                            <p><i class="fa fa-phone"></i> <?= htmlspecialchars($transport['driver_phone'] ?? 'N/A') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (!empty($transport['driver_cccd']) || !empty($transport['driver_birthdate'])): ?>
                                                    <div class="row">
                                                        <?php if (!empty($transport['driver_cccd'])): ?>
                                                            <div class="col-sm-6">
                                                                <div class="info-group-sm">
                                                                    <label>CCCD:</label>
                                                                    <p><?= htmlspecialchars($transport['driver_cccd']) ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($transport['driver_birthdate'])): ?>
                                                            <div class="col-sm-6">
                                                                <div class="info-group-sm">
                                                                    <label>Ngày sinh:</label>
                                                                    <p><?= date('d/m/Y', strtotime($transport['driver_birthdate'])) ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Chưa có thông tin phương tiện</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- KHÁCH SẠN -->
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h4><i class="fa fa-hotel"></i> Chỗ ở</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['accommodations'])): ?>
                        <div class="row">
                            <?php foreach ($booking['accommodations'] as $index => $accommodation): ?>
                                <div class="col-md-6">
                                    <div class="accommodation-card">
                                        <div class="accommodation-header">
                                            <i class="fa fa-hotel"></i>
                                            <h5>Khách sạn <?= $index + 1 ?></h5>
                                        </div>
                                        <div class="accommodation-body">
                                            <div class="info-group-sm">
                                                <label><i class="fa fa-building-o"></i> Tên khách sạn:</label>
                                                <p class="hotel-name"><?= htmlspecialchars($accommodation['name'] ?? 'N/A') ?></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="info-group-sm">
                                                        <label><i class="fa fa-bed"></i> Loại:</label>
                                                        <p>
                                                            <span class="badge badge-pink">
                                                                <?= htmlspecialchars($accommodation['type'] ?? 'N/A') ?>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="info-group-sm">
                                                        <label><i class="fa fa-phone"></i> SĐT:</label>
                                                        <p><?= htmlspecialchars($accommodation['sdt'] ?? 'N/A') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-sm">
                                                <label><i class="fa fa-map-marker"></i> Địa chỉ:</label>
                                                <p><?= htmlspecialchars($accommodation['address'] ?? 'N/A') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Chưa có thông tin chỗ ở</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- LỊCH TRÌNH -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4><i class="fa fa-calendar"></i> Lịch trình chi tiết</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['schedules'])): ?>
                        <?php foreach ($booking['schedules'] as $schedule): ?>
                            <div class="schedule-card">
                                <div class="schedule-header">
                                    <div class="schedule-day">
                                        <span class="day-number">Ngày <?= $schedule['day_number'] ?></span>
                                    </div>
                                </div>
                                <div class="schedule-body">
                                    <div class="schedule-item">
                                        <div class="schedule-icon">
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                        <div class="schedule-content">
                                            <label>Địa điểm:</label>
                                            <p class="schedule-location"><?= htmlspecialchars($schedule['location']) ?></p>
                                        </div>
                                    </div>
                                    <div class="schedule-item">
                                        <div class="schedule-icon">
                                            <i class="fa fa-list-ul"></i>
                                        </div>
                                        <div class="schedule-content">
                                            <label>Hoạt động:</label>
                                            <p class="schedule-activities"><?= nl2br(htmlspecialchars($schedule['activities'])) ?></p>
                                        </div>
                                    </div>
                                    <?php if (!empty($schedule['notes'])): ?>
                                        <div class="schedule-item">
                                            <div class="schedule-icon">
                                                <i class="fa fa-info-circle"></i>
                                            </div>
                                            <div class="schedule-content">
                                                <label>Ghi chú:</label>
                                                <p class="schedule-notes"><?= htmlspecialchars($schedule['notes']) ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Chưa có lịch trình</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- DANH SÁCH KHÁCH HÀNG -->
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4><i class="fa fa-users"></i> Danh sách khách hàng (<?= count($booking['people'] ?? []) ?> người)</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($booking['people'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover people-table">
                                <thead>
                                    <tr>
                                        <th width="5%">STT</th>
                                        <th width="20%">Họ và tên</th>
                                        <th width="20%">Ngày sinh</th>
                                        <th width="20%">Số điện thoại</th>
                                        <th width="15%">CCCD</th>
                                        <th width="30%">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($booking['people'] as $index => $person): ?>
                                        <tr>
                                            <td class="text-center"><strong><?= $index + 1 ?></strong></td>
                                            <td>
                                                <i class="fa fa-user"></i>
                                                <strong><?= htmlspecialchars($person['fullname']) ?></strong>
                                            </td>
                                            <td>
                                                <i class="fa fa-birthday-cake"></i>
                                                <?= date('d/m/Y', strtotime($person['date'])) ?>
                                            </td>
                                            <td>
                                                <i class="fa fa-phone"></i>
                                                <?= htmlspecialchars($person['phone']) ?>
                                            </td>
                                            <td>
                                                <i class="fa fa-id-card"></i>
                                                <?= htmlspecialchars($person['cccd'] ?? 'N/A') ?>
                                            </td>
                                            <td>
                                                <i class="fa fa-info-circle"></i>
                                                <?= htmlspecialchars($person['note'] ?? 'Không có ghi chú') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted"><i class="fa fa-exclamation-circle"></i> Chưa có danh sách khách hàng</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- LỊCH ĐIỂM DANH -->
            <!-- LỊCH ĐIỂM DANH -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><i class="fa fa-calendar-check-o"></i> Lịch điểm danh</h4>
                </div>
                <div class="panel-body">
                    <?php if (!empty($attendanceSummary)): ?>

                        <!-- ✅ FILTER CHỌN NGÀY -->
                        <div class="attendance-date-filter">
                            <div class="filter-header">
                                <i class="fa fa-filter"></i>
                                <span>Chọn ngày xem chi tiết:</span>
                            </div>
                            <div class="date-buttons-wrapper">
                                <button class="date-filter-btn active" data-date="all" onclick="filterAttendanceByDate('all')">
                                    <i class="fa fa-calendar"></i>
                                    Tất cả ngày
                                </button>
                                <?php foreach ($attendanceSummary as $summary): ?>
                                    <button class="date-filter-btn" data-date="<?= $summary['attendance_date'] ?>"
                                        onclick="filterAttendanceByDate('<?= $summary['attendance_date'] ?>')">
                                        <i class="fa fa-calendar-day"></i>
                                        <?= $summary['formatted_date'] ?>
                                        <span class="date-count">(<?= $summary['present_count'] + $summary['absent_count'] ?>)</span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- TỔNG QUAN THEO NGÀY -->
                        <div class="attendance-summary-cards">
                            <?php foreach ($attendanceSummary as $summary): ?>
                                <div class="attendance-summary-card">
                                    <div class="summary-date">
                                        <i class="fa fa-calendar"></i>
                                        <?= $summary['formatted_date'] ?>
                                    </div>
                                    <div class="summary-stats">
                                        <div class="stat-item stat-present">
                                            <i class="fa fa-check-circle"></i>
                                            <span><?= $summary['present_count'] ?> Có mặt</span>
                                        </div>
                                        <div class="stat-item stat-absent">
                                            <i class="fa fa-times-circle"></i>
                                            <span><?= $summary['absent_count'] ?> Vắng mặt</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- CHI TIẾT ĐIỂM DANH -->
                        <h6 style="margin-top: 30px; margin-bottom: 20px; color: #34495e; font-weight: 600;">
                            <i class="fa fa-list"></i> Chi tiết điểm danh
                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover attendance-table">
                                <thead>
                                    <tr>
                                        <th width="4%">STT</th>
                                        <th width="15%">Họ và Tên</th>
                                        <th width="10%">Ngày Sinh</th>
                                        <th width="10%">Số Điện Thoại</th>
                                        <th width="9%">CCCD</th>
                                        <th width="10%">Ngày Điểm Danh</th>
                                        <th width="8%">Buổi</th>
                                        <th width="9%">Giờ Điểm Danh</th>
                                        <th width="9%">Trạng Thái</th>
                                        <th width="14%">Ghi Chú</th>
                                    </tr>
                                </thead>
                                <tbody id="attendance-table-body">
                                    <?php
                                    $currentDate = '';
                                    $stt = 0;
                                    foreach ($attendances as $attendance):
                                        $stt++;
                                        $isNewDate = ($currentDate !== $attendance['attendance_date']);
                                        $currentDate = $attendance['attendance_date'];
                                    ?>
                                        <tr class="attendance-row" data-date="<?= $attendance['attendance_date'] ?>">
                                            <td class="text-center"><?= $stt ?></td>
                                            <td>
                                                <i class="fa fa-user"></i>
                                                <strong><?= htmlspecialchars($attendance['fullname']) ?></strong>
                                            </td>
                                            <td>
                                                <i class="fa fa-birthday-cake"></i>
                                                <?= date('d/m/Y', strtotime($attendance['date'])) ?>
                                            </td>
                                            <td>
                                                <i class="fa fa-phone"></i>
                                                <?= htmlspecialchars($attendance['phone']) ?>
                                            </td>
                                            <td>
                                                <i class="fa fa-id-card"></i>
                                                <?= htmlspecialchars($attendance['cccd'] ?? 'N/A') ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="date-badge">
                                                    <?= $attendance['formatted_date'] ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($attendance['session'] === 'morning'): ?>
                                                    <span class="session-badge session-morning">
                                                        <i class="fa fa-sun-o"></i> Sáng
                                                    </span>
                                                <?php elseif ($attendance['session'] === 'afternoon'): ?>
                                                    <span class="session-badge session-afternoon">
                                                        <i class="fa fa-cloud"></i> Chiều
                                                    </span>
                                                <?php elseif ($attendance['session'] === 'evening'): ?>
                                                    <span class="session-badge session-evening">
                                                        <i class="fa fa-moon-o"></i> Tối
                                                    </span>
                                                <?php else: ?>
                                                    <span class="session-badge session-default">
                                                        <?= htmlspecialchars($attendance['session'] ?? 'N/A') ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($attendance['checkin_time'])): ?>
                                                    <span class="check-time-badge">
                                                        <i class="fa fa-clock-o"></i>
                                                        <?= date('H:i', strtotime($attendance['checkin_time'])) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($attendance['status'] === 'present'): ?>
                                                    <span class="status-badge status-present">
                                                        <i class="fa fa-check-circle"></i> Có mặt
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge status-absent">
                                                        <i class="fa fa-times-circle"></i> Vắng mặt
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <i class="fa fa-comment"></i>
                                                <?= htmlspecialchars($attendance['note'] ?? 'Không có ghi chú') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Hiển thị thông tin khi không có dữ liệu -->
                        <div id="no-attendance-data" style="display: none;" class="no-data-message">
                            <i class="fa fa-exclamation-circle" style="font-size: 48px; color: #95a5a6; margin-bottom: 15px;"></i>
                            <p style="color: #7f8c8d; margin: 0; font-size: 16px;">Không có dữ liệu điểm danh cho ngày đã chọn</p>
                        </div>

                    <?php else: ?>
                        <div class="no-data-message">
                            <i class="fa fa-exclamation-circle" style="font-size: 48px; color: #95a5a6; margin-bottom: 15px;"></i>
                            <p style="color: #7f8c8d; margin: 0; font-size: 16px;">Chưa có dữ liệu điểm danh</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* ==================== DATE FILTER ==================== */
        .attendance-date-filter {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #667eea;
        }

        .filter-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
        }

        .filter-header i {
            color: #667eea;
            font-size: 18px;
        }

        .date-buttons-wrapper {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .date-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .date-filter-btn:hover {
            background: #f8f9ff;
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .date-filter-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .date-filter-btn i {
            font-size: 16px;
        }

        .date-count {
            background: rgba(255, 255, 255, 0.3);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            margin-left: 5px;
        }

        .date-filter-btn.active .date-count {
            background: rgba(255, 255, 255, 0.2);
        }


        /* ==================== ATTENDANCE SUMMARY CARDS ==================== */
        .attendance-summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .attendance-summary-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 10px;
            border-left: 5px solid #3498db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s;
        }

        .attendance-summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .summary-date {
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-date i {
            color: #3498db;
        }

        .summary-stats {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
        }

        .stat-present {
            color: #27ae60;
        }

        .stat-absent {
            color: #e74c3c;
        }

        /* ==================== ATTENDANCE TABLE ==================== */
        .attendance-table {
            width: 100%;
            margin-bottom: 0;
        }

        .attendance-table thead {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .attendance-table thead th {
            font-weight: 600;
            border: none;
            padding: 15px;
            font-size: 13px;
            white-space: nowrap;
        }

        .attendance-table tbody tr {
            transition: background 0.3s;
        }

        .attendance-table tbody tr:hover:not(.date-separator) {
            background: #e3f2fd;
        }

        .attendance-table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            font-size: 13px;
        }

        /* Make table responsive and full width */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .date-buttons-wrapper {
                flex-direction: column;
            }

            .date-filter-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* ==================== ANIMATION ==================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .attendance-row {
            animation: fadeIn 0.3s ease-in-out;
        }

        /* ==================== GLOBAL STYLES ==================== */
        html,
        body {
            overflow: auto !important;
            height: auto !important;
            background: #f5f7fa;
        }

        .booking-detail {
            padding: 20px;
        }

        /* ==================== HEADER ==================== */
        .action-buttons {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
        }

        .page-title {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #3498db;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
            color: #3498db;
        }

        .status-badge {
            font-size: 14px;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-pending {
            background: #f39c12;
            color: white;
        }

        .status-confirmed {
            background: #3498db;
            color: white;
        }

        .status-completed {
            background: #27ae60;
            color: white;
        }

        .status-cancelled {
            background: #e74c3c;
            color: white;
        }

        /* ==================== PANELS ==================== */
        .panel {
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 8px;
            overflow: hidden;
        }

        .panel-heading {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 20px;
            border: none;
        }

        .panel-heading h4 {
            margin: 0;
            font-weight: 600;
            color: white;
            font-size: 18px;
        }

        .panel-primary .panel-heading {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .panel-success .panel-heading {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .panel-warning .panel-heading {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }

        .panel-danger .panel-heading {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .panel-body {
            padding: 25px;
            background: white;
        }

        /* ==================== INFO BOXES ==================== */
        .info-box {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 28px;
            color: white;
        }

        .info-icon.bg-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .info-icon.bg-success {
            background: linear-gradient(135deg, #27ae60, #229954);
        }

        .info-icon.bg-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .info-icon.bg-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            display: block;
            font-size: 13px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .info-value {
            display: block;
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }

        /* ==================== INFO GROUPS ==================== */
        .info-group {
            margin-bottom: 20px;
        }

        .info-group label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .info-group p {
            margin: 0;
            padding: 12px 15px;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            border-radius: 4px;
            line-height: 1.6;
        }

        .info-group-sm {
            margin-bottom: 12px;
        }

        .info-group-sm label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            display: block;
            font-size: 12px;
        }

        .info-group-sm p {
            margin: 0;
            padding: 8px 10px;
            background: #f8f9fa;
            border-radius: 4px;
            font-size: 13px;
        }

        /* ==================== PRICE SUMMARY ==================== */
        .price-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #dee2e6;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .price-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }

        .price-value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }

        .price-per-person {
            color: #e74c3c;
            font-size: 18px;
        }

        .price-item.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #dee2e6;
        }

        .price-item.total .price-label {
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
        }

        .price-total {
            font-size: 24px !important;
            font-weight: 800 !important;
            color: #27ae60 !important;
        }

        /* ==================== SPECIAL REQUEST ==================== */
        .special-request-content {
            position: relative;
            padding: 25px;
            background: #fff9e6;
            border-left: 4px solid #f39c12;
            border-radius: 6px;
        }

        .special-request-content .fa-quote-left {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 20px;
            color: #f39c12;
            opacity: 0.3;
        }

        .special-request-content .fa-quote-right {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 20px;
            color: #f39c12;
            opacity: 0.3;
        }

        .special-request-content p {
            margin: 0;
            font-size: 15px;
            line-height: 1.8;
            color: #856404;
            font-style: italic;
        }

        /* ==================== DESTINATION ==================== */
        .destination-name,
        .tour-name {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #2c3e50 !important;
        }

        /* ==================== GUIDE CARD ==================== */
        .guide-card {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: linear-gradient(135deg, #fff5e6 0%, #ffe8cc 100%);
            border-radius: 10px;
            border-left: 5px solid #f39c12;
        }

        .guide-avatar {
            font-size: 80px;
            color: #f39c12;
            line-height: 1;
        }

        .guide-details {
            flex: 1;
        }

        .guide-name {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .guide-contact {
            display: flex;
            gap: 30px;
            margin-bottom: 15px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .contact-item i {
            color: #f39c12;
        }

        .guide-info {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .guide-info .badge {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-warning {
            background: #f39c12;
        }

        .badge-info {
            background: #5bc0de;
        }

        /* ==================== TRANSPORT CARD ==================== */
        .transport-card {
            background: white;
            border: 2px solid #3498db;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .transport-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }

        .transport-header {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .transport-header i {
            font-size: 24px;
        }

        .transport-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
        }

        .transport-body {
            padding: 20px;
        }

        .pickup-section,
        .driver-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .pickup-section h6,
        .driver-section h6 {
            font-size: 14px;
            font-weight: 700;
            color: #3498db;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #dee2e6;
        }

        .time-badge {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        /* ==================== ACCOMMODATION CARD ==================== */
        .accommodation-card {
            background: white;
            border: 2px solid #e91e63;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .accommodation-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(233, 30, 99, 0.3);
        }

        .accommodation-header {
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .accommodation-header i {
            font-size: 24px;
        }

        .accommodation-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
        }

        .accommodation-body {
            padding: 20px;
        }

        .hotel-name {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #e91e63 !important;
        }

        .badge-pink {
            background: #e91e63;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
        }

        /* ==================== SCHEDULE CARD ==================== */
        .schedule-card {
            background: white;
            border: 2px solid #27ae60;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .schedule-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }

        .schedule-header {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            padding: 20px;
        }

        .schedule-day {
            display: flex;
            align-items: center;
            gap: 20px;
            color: white;
        }

        .day-number {
            font-size: 22px;
            font-weight: 700;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
        }

        .day-date {
            font-size: 16px;
            font-weight: 500;
        }

        .schedule-body {
            padding: 25px;
        }

        .schedule-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .schedule-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f5e9;
            color: #27ae60;
            border-radius: 50%;
            font-size: 18px;
            flex-shrink: 0;
        }

        .schedule-content {
            flex: 1;
        }

        .schedule-content label {
            font-weight: 600;
            color: #27ae60;
            margin-bottom: 8px;
            display: block;
            font-size: 13px;
        }

        .schedule-location {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #2c3e50 !important;
        }

        .schedule-activities {
            line-height: 1.8 !important;
            color: #555 !important;
        }

        .schedule-notes {
            color: #e74c3c !important;
            font-style: italic !important;
            background: #fff5f5 !important;
            padding: 10px 15px !important;
            border-left: 4px solid #e74c3c !important;
            border-radius: 4px !important;
        }

        /* ==================== PEOPLE TABLE ==================== */
        .people-table {
            margin-bottom: 0;
            font-size: 14px;
        }

        .people-table thead {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .people-table thead th {
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .people-table tbody tr {
            transition: background 0.3s;
        }

        .people-table tbody tr:hover {
            background: #fff9e6;
        }

        .people-table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        /* ==================== PRINT STYLES ==================== */
        @media print {

            .action-buttons,
            .btn {
                display: none !important;
            }

            .panel {
                page-break-inside: avoid;
            }

            .panel-heading {
                background: #333 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .info-box {
                flex-direction: column;
                text-align: center;
            }

            .guide-card {
                flex-direction: column;
                text-align: center;
            }

            .guide-contact {
                flex-direction: column;
                gap: 10px;
            }

            .schedule-day {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>

    <script>
        /**
         * ✅ LỌC ĐIỂM DANH THEO NGÀY
         */
        function filterAttendanceByDate(selectedDate) {
            // 1. Update active button
            const buttons = document.querySelectorAll('.date-filter-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-date') === selectedDate) {
                    btn.classList.add('active');
                }
            });

            // 2. Filter table rows
            const rows = document.querySelectorAll('.attendance-row');
            const noDataDiv = document.getElementById('no-attendance-data');
            let visibleCount = 0;
            let stt = 0;

            rows.forEach(row => {
                const rowDate = row.getAttribute('data-date');

                if (selectedDate === 'all' || rowDate === selectedDate) {
                    row.style.display = '';
                    stt++;
                    // Update STT
                    const sttCell = row.querySelector('td:first-child');
                    sttCell.textContent = stt;
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // 3. Show/hide no data message
            if (visibleCount === 0) {
                noDataDiv.style.display = 'block';
                document.getElementById('attendance-table-body').parentElement.parentElement.style.display = 'none';
            } else {
                noDataDiv.style.display = 'none';
                document.getElementById('attendance-table-body').parentElement.parentElement.style.display = 'table';
            }

            // 4. Log for debugging
            console.log(`✅ Filtered: ${visibleCount} rows for date: ${selectedDate}`);
        }

        // ✅ Auto-load all dates on page load
        document.addEventListener('DOMContentLoaded', function() {
            filterAttendanceByDate('all');
        });
    </script>
    <?php require_once __DIR__ . '/../../layout/admin/footer.php';; ?>