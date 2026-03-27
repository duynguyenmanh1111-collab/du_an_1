<?php
require_once __DIR__ . '/../../layout/admin/header.php';

// echo json_encode($booking, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
// Decode JSON data nếu cần
if (isset($booking['tour']) && is_string($booking['tour'])) {
    $booking['tour'] = json_decode($booking['tour'], true);
}
if (isset($booking['customer']) && is_string($booking['customer'])) {
    $booking['customer'] = json_decode($booking['customer'], true);
}
if (isset($booking['destination']) && is_string($booking['destination'])) {
    $booking['destination'] = json_decode($booking['destination'], true);
}
if (isset($booking['transports']) && is_string($booking['transports'])) {
    $booking['transports'] = json_decode($booking['transports'], true);
}
if (isset($booking['people']) && is_string($booking['people'])) {
    $booking['people'] = json_decode($booking['people'], true);
}
if (isset($booking['schedules']) && is_string($booking['schedules'])) {
    $booking['schedules'] = json_decode($booking['schedules'], true);
}
if (isset($booking['customer_support']) && is_string($booking['customer_support'])) {
    $booking['customer_support'] = json_decode($booking['customer_support'], true);
}
if (isset($booking['accommodations']) && is_string($booking['accommodations'])) {
    $booking['accommodations'] = json_decode($booking['accommodations'], true);
}
if (isset($booking['category']) && is_string($booking['category'])) {
    $booking['category'] = json_decode($booking['category'], true);
}
if (isset($booking['user']) && is_string($booking['user'])) {
    $booking['user'] = json_decode($booking['user'], true);
}
if (isset($booking['guide']) && is_string($booking['guide'])) {
    $booking['guide'] = json_decode($booking['guide'], true);
}
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Cập nhật booking</h2>

            <!-- ✅ ALERT MESSAGES -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>Lỗi!</strong> <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
            <?php unset($_SESSION['error']);
            endif; ?>

            <?php if (isset($_SESSION['warning'])): ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-warning"></i>
                    <strong>Cảnh báo!</strong> <?= htmlspecialchars($_SESSION['warning']) ?>
                </div>
            <?php unset($_SESSION['warning']);
            endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-check-circle"></i>
                    <strong>Thành công!</strong> <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
            <?php unset($_SESSION['success']);
            endif; ?>

            <div class="form-grids row widget-shadow">
                <div class="form-title">
                    <h4>Form cập nhật thông tin booking</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=bookings-update" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo isset($booking['id']) ? $booking['id'] : ''; ?>">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo isset($booking['tour']['name']) ? htmlspecialchars($booking['tour']['name']) : ''; ?>"
                                placeholder="Nhập tên tour" disabled>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_id"
                                value="<?php echo isset($booking['category']['name']) ? htmlspecialchars($booking['category']['name']) : ''; ?>"
                                disabled>
                        </div>

                        <!-- HDV -->
                        <div class="form-group">
                            <label for="guide_id">
                                Hướng Dẫn Viên <span class="text-danger">*</span>
                                <small class="text-muted" id="guide-status"></small>
                            </label>
                            <select class="form-control" id="guide_id" name="guide_id" required>
                                <option value="">-- Chọn Hướng Dẫn Viên --</option>
                                <?php
                                // Lấy danh sách ID của HDV có sẵn
                                $availableGuideIds = array_column($availableGuides ?? [], 'id');

                                foreach ($allGuide as $gui):
                                    $isAvailable = in_array($gui['id'], $availableGuideIds);
                                    $isCurrentGuide = (isset($booking['guide_id']) && $booking['guide_id'] == $gui['id']);

                                    // Nếu là HDV hiện tại hoặc HDV có sẵn thì cho chọn
                                    if ($isCurrentGuide || $isAvailable):
                                ?>
                                        <option value="<?= $gui['id'] ?>"
                                            <?= $isCurrentGuide ? 'selected' : '' ?>
                                            data-phone="<?= htmlspecialchars($gui['phone'] ?? '') ?>"
                                            data-email="<?= htmlspecialchars($gui['email'] ?? '') ?>">
                                            <?= htmlspecialchars($gui['full_name']) ?>
                                            <?php if (!empty($gui['phone'])): ?>
                                                (<?= htmlspecialchars($gui['phone']) ?>)
                                            <?php endif; ?>
                                            <?= $isCurrentGuide ? ' [Hiện tại]' : '' ?>
                                        </option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>

                            <div id="guide-conflict-warning" class="alert alert-danger" style="display: none; margin-top: 10px;">
                                <i class="fa fa-exclamation-triangle"></i>
                                <strong>⚠️ Hướng dẫn viên bị trùng lịch!</strong>
                                <ul id="guide-conflict-list"></ul>
                            </div>

                            <small class="text-info">
                                <i class="fa fa-info-circle"></i>
                                Chỉ hiển thị HDV không bị trùng lịch trong khoảng thời gian này
                            </small>
                        </div>

                        <!-- Điểm đến -->
                        <div class="form-group">
                            <label for="tour_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="tour_id" name="tour_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php foreach ($allTour as $tour):
                                    $tourSchedules = [];
                                    if (isset($tour['schedules'])) {
                                        $tourSchedules = is_string($tour['schedules'])
                                            ? json_decode($tour['schedules'], true)
                                            : $tour['schedules'];
                                    }
                                    $isSelected = (isset($booking['tour_id']) && $booking['tour_id'] == $tour['id']);
                                ?>
                                    <option value="<?= $tour['id'] ?>"
                                        data-name="<?= htmlspecialchars($tour['name']) ?>"
                                        data-price="<?= $tour['price'] ?>"
                                        data-description="<?= htmlspecialchars($tour['description'] ?? '') ?>"
                                        data-category="<?= $tour['category_id'] ?>"
                                        data-start="<?= $tour['start_date'] ?? '' ?>"
                                        data-end="<?= $tour['end_date'] ?? '' ?>"
                                        data-schedules='<?= htmlspecialchars(json_encode($tourSchedules ?: []), ENT_QUOTES, 'UTF-8') ?>'
                                        <?= $isSelected ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tour['name']) ?> - <?= number_format($tour['price']) ?> VNĐ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4" disabled><?php echo isset($booking['tour']['description']) ? htmlspecialchars($booking['tour']['description']) : ''; ?></textarea>
                        </div>

                        <!-- Yêu cầu đặc biệt -->
                        <div class="form-group">
                            <label for="special_request">Yêu cầu đặc biệt</label>
                            <textarea class="form-control" id="special_request" name="special_request" rows="3"><?php echo isset($booking['special_request']) ? htmlspecialchars($booking['special_request']) : ''; ?></textarea>
                        </div>

                        <!-- Ngày bắt đầu và kết thúc -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="<?php echo isset($booking['start_date']) ? $booking['start_date'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="<?php echo isset($booking['end_date']) ? $booking['end_date'] : ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="<?php echo isset($booking['tour']['price']) ? $booking['tour']['price'] : ''; ?>"
                                min="0" disabled>
                        </div>

                        <!-- Trạng thái -->
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="pending" <?php echo (isset($booking['status']) && $booking['status'] == 'pending') ? 'selected' : ''; ?>>Chờ khởi hành</option>
                                        <option value="confirmed" <?php echo (isset($booking['status']) && $booking['status'] == 'confirmed') ? 'selected' : ''; ?>>Đang khởi hành</option>
                                        <option value="cancelled" <?php echo (isset($booking['status']) && $booking['status'] == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                                        <option value="completed" <?php echo (isset($booking['status']) && $booking['status'] == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_status">Thanh toán</label>
                                    <select class="form-control" id="payment_status" name="payment_status">
                                        <option value="unpaid" <?php echo (isset($booking['payment_status']) && $booking['payment_status'] == 'unpaid') ? 'selected' : ''; ?>>Chưa thanh toán</option>
                                        <option value="paid" <?php echo (isset($booking['payment_status']) && $booking['payment_status'] == 'paid') ? 'selected' : ''; ?>>Đã thanh toán</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>

                        <!-- Số chỗ tối đa -->
                        <div class="form-group">
                            <label for="max_people">Số chỗ tối đa <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="max_people" name="max_people"
                                value="<?php echo isset($booking['max_people']) ? $booking['max_people'] : 30; ?>"
                                min="1" max="999" required>
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> Giới hạn số người tối đa
                            </small>
                        </div>

                        <!-- Thông tin chỗ trống -->
                        <?php if (isset($seatInfo)): ?>
                            <div class="alert <?= $seatInfo['available_seats'] > 0 ? 'alert-success' : 'alert-danger' ?>">
                                <h4><i class="fa fa-users"></i> Thông tin chỗ ngồi</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Tổng:</strong>
                                        <span class="badge" style="font-size: 14px; background: #337ab7;">
                                            <?= $seatInfo['max_people'] ?> chỗ
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Đã đặt:</strong>
                                        <span class="badge" style="font-size: 14px; background: #f0ad4e;">
                                            <?= $seatInfo['current_people'] ?> người
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Còn trống:</strong>
                                        <span class="badge" style="font-size: 14px; background: <?= $seatInfo['available_seats'] > 0 ? '#5cb85c' : '#d9534f' ?>;">
                                            <?= $seatInfo['available_seats'] ?> chỗ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- PHƯƠNG TIỆN -->
                        <h4 class="text-success" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5cb85c; padding-bottom: 10px;">
                            <i class="fa fa-bus"></i> Phương tiện di chuyển
                        </h4>

                        <div id="transports-container">
                            <?php
                            $transports = isset($booking['transports']) ? $booking['transports'] : [];
                            if (empty($transports)) {
                                $transports = [['type' => '', 'seats' => '', 'company' => '', 'driver_name' => '', 'driver_phone' => '', 'driver_cccd' => '', 'driver_birthdate' => '', 'license_plate' => '', 'pickup_location' => '', 'pickup_address' => '', 'pickup_time' => '']];
                            }
                            foreach ($transports as $index => $transport):
                            ?>
                                <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
                                    <?php if (isset($transport['id']) && !empty($transport['id'])): ?>
                                        <input type="hidden" name="transports[<?= $index ?>][id]" value="<?= $transport['id'] ?>">
                                    <?php endif; ?>
                                    <h5>Phương tiện #<?= $index + 1 ?></h5>

                                    <!-- THÔNG TIN PHƯƠNG TIỆN -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Loại phương tiện</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][type]"
                                                    value="<?= isset($transport['type']) ? htmlspecialchars($transport['type']) : '' ?>"
                                                    placeholder="VD: Xe du lịch 45 chỗ">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Số chỗ</label>
                                                <input type="number" class="form-control" name="transports[<?= $index ?>][seats]"
                                                    value="<?= isset($transport['seats']) ? $transport['seats'] : '' ?>"
                                                    placeholder="45">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Công ty</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][company]"
                                                    value="<?= isset($transport['company']) ? htmlspecialchars($transport['company']) : '' ?>"
                                                    placeholder="VD: Hoàng Long">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Biển số xe</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][license_plate]"
                                                    value="<?= isset($transport['license_plate']) ? htmlspecialchars($transport['license_plate']) : '' ?>"
                                                    placeholder="29A-12345">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ✅ ĐIỂM TẬP TRUNG / ĐÓN KHÁCH -->
                                    <div class="row" style="background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                                        <div class="col-md-12">
                                            <h6 style="color: #2e7d32; margin-bottom: 10px;">
                                                <i class="fa fa-map-marker"></i> Điểm tập trung / Đón khách
                                            </h6>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa điểm đón <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][pickup_location]"
                                                    value="<?= isset($transport['pickup_location']) ? htmlspecialchars($transport['pickup_location']) : '' ?>"
                                                    placeholder="VD: Bến xe Mỹ Đình"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Địa chỉ chi tiết</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][pickup_address]"
                                                    value="<?= isset($transport['pickup_address']) ? htmlspecialchars($transport['pickup_address']) : '' ?>"
                                                    placeholder="VD: Cổng số 3, Bến xe Mỹ Đình, Nam Từ Liêm, Hà Nội">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Giờ khởi hành <span class="text-danger">*</span></label>
                                                <input type="time" class="form-control" name="transports[<?= $index ?>][pickup_time]"
                                                    value="<?= isset($transport['pickup_time']) ? substr($transport['pickup_time'], 0, 5) : '' ?>"

                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- THÔNG TIN TÀI XẾ -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tên tài xế</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][driver_name]"
                                                    value="<?= isset($transport['driver_name']) ? htmlspecialchars($transport['driver_name']) : '' ?>"
                                                    placeholder="Nguyễn Văn Tài">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>SĐT tài xế</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][driver_phone]"
                                                    value="<?= isset($transport['driver_phone']) ? htmlspecialchars($transport['driver_phone']) : '' ?>"
                                                    placeholder="0123456789">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>CCCD tài xế</label>
                                                <input type="text" class="form-control" name="transports[<?= $index ?>][driver_cccd]"
                                                    value="<?= isset($transport['driver_cccd']) ? htmlspecialchars($transport['driver_cccd']) : '' ?>"
                                                    placeholder="001234567890">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Ngày sinh</label>
                                                <input type="date" class="form-control" name="transports[<?= $index ?>][driver_birthdate]"
                                                    value="<?= isset($transport['driver_birthdate']) ? $transport['driver_birthdate'] : '' ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-danger btn-sm remove-transport"
                                        <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-transport">
                            <i class="fa fa-plus"></i> Thêm phương tiện
                        </button>

                        <!-- KHÁCH SẠN -->
                        <h4 class="text-warning" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #f0ad4e; padding-bottom: 10px;">
                            <i class="fa fa-hotel"></i> Khách sạn
                        </h4>

                        <div id="accommodations-container">
                            <?php
                            $accommodations = isset($booking['accommodations']) ? $booking['accommodations'] : [];
                            if (empty($accommodations)) {
                                $accommodations = [['name' => '', 'type' => '', 'address' => '']];
                            }
                            foreach ($accommodations as $index => $accommodation):
                            ?>
                                <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
                                    <?php if (isset($accommodation['id']) && !empty($accommodation['id'])): ?>
                                        <input type="hidden" name="accommodations[<?= $index ?>][id]" value="<?= $accommodation['id'] ?>">
                                    <?php endif; ?>
                                    <h5>Khách sạn #<?= $index + 1 ?></h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tên</label>
                                                <input type="text" class="form-control" name="accommodations[<?= $index ?>][name]"
                                                    value="<?= isset($accommodation['name']) ? htmlspecialchars($accommodation['name']) : '' ?>"
                                                    placeholder="VD: Hạ Long Resort">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Loại</label>
                                                <select class="form-control" name="accommodations[<?= $index ?>][type]">
                                                    <option value="">Chọn</option>
                                                    <option value="Hotel" <?= (isset($accommodation['type']) && $accommodation['type'] == 'Hotel') ? 'selected' : '' ?>>Hotel</option>
                                                    <option value="Resort" <?= (isset($accommodation['type']) && $accommodation['type'] == 'Resort') ? 'selected' : '' ?>>Resort</option>
                                                    <option value="Homestay" <?= (isset($accommodation['type']) && $accommodation['type'] == 'Homestay') ? 'selected' : '' ?>>Homestay</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <input type="text" class="form-control" name="accommodations[<?= $index ?>][address]"
                                                    value="<?= isset($accommodation['address']) ? htmlspecialchars($accommodation['address']) : '' ?>"
                                                    placeholder="Bãi Cháy, Quảng Ninh">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" class="form-control" name="accommodations[<?= $index ?>][sdt]"
                                                    value="<?= isset($accommodation['sdt']) ? htmlspecialchars($accommodation['sdt']) : '' ?>"
                                                    placeholder="0123456789">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation"
                                                <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm" id="add-accommodation">
                            <i class="fa fa-plus"></i> Thêm khách sạn
                        </button>

                        <!-- LỊCH TRÌNH -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-calendar"></i> Lịch trình
                        </h4>

                        <div id="schedules-container">
                            <?php
                            $schedules = isset($booking['schedules']) ? $booking['schedules'] : [];
                            if (empty($schedules)) {
                                $schedules = [['day_number' => 1, 'date' => '', 'location' => '', 'activities' => '', 'notes' => '']];
                            }
                            foreach ($schedules as $index => $schedule):
                            ?>
                                <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                    <?php if (isset($schedule['id']) && !empty($schedule['id'])): ?>
                                        <input type="hidden" name="schedules[<?= $index ?>][id]" value="<?= $schedule['id'] ?>">
                                    <?php endif; ?>
                                    <h5>Ngày <?= isset($schedule['day_number']) ? $schedule['day_number'] : ($index + 1) ?></h5>
                                    <input type="hidden" name="schedules[<?= $index ?>][day_number]" value="<?= $index + 1 ?>">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa điểm</label>
                                                <input type="text" class="form-control" name="schedules[<?= $index ?>][location]"
                                                    value="<?= isset($schedule['location']) ? htmlspecialchars($schedule['location']) : '' ?>"
                                                    placeholder="VD: Hà Nội - Hạ Long" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hoạt động</label>
                                                <textarea class="form-control" name="schedules[<?= $index ?>][activities]" rows="2" disabled><?= isset($schedule['activities']) ? htmlspecialchars($schedule['activities']) : '' ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <input type="text" class="form-control" name="schedules[<?= $index ?>][notes]"
                                            value="<?= isset($schedule['notes']) ? htmlspecialchars($schedule['notes']) : '' ?>"
                                            placeholder="Mang CMND/CCCD" disabled>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- KHÁCH HÀNG -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-users"></i> Danh sách khách hàng
                        </h4>

                        <div id="people-container">
                            <?php
                            $peoples = isset($booking['people']) ? $booking['people'] : [];
                            if (empty($peoples)) {
                                $peoples = [['fullname' => '', 'date' => '', 'phone' => '', 'cccd' => '']];
                            }
                            foreach ($peoples as $index => $people):
                            ?>
                                <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                    <h5 style="display: flex; justify-content: space-between;">
                                        <span>
                                            Khách hàng #<?= $index + 1 ?>
                                            <span class="badge person-type-badge" style="background: #5cb85c; font-size: 11px;">
                                                <?= !empty($people['id']) ? 'Đã có' : 'Mới' ?>
                                            </span>
                                        </span>
                                        <button type="button" class="btn btn-danger btn-sm remove-people"
                                            <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </h5>

                                    <?php if (isset($people['id']) && !empty($people['id'])): ?>
                                        <input type="hidden" name="peoples[<?= $index ?>][id]" value="<?= $people['id'] ?>">
                                    <?php endif; ?>

                                    <!-- Dropdown chọn người -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <i class="fa fa-database"></i> Chọn từ danh sách
                                                    <small class="text-muted">(Không trùng lịch)</small>
                                                </label>
                                                <select class="form-control person-selector"
                                                    name="peoples[<?= $index ?>][existing_id]"
                                                    data-index="<?= $index ?>">
                                                    <option value="new">➕ Thêm mới</option>
                                                    <?php
                                                    if (isset($availablePeople) && !empty($availablePeople)):
                                                        foreach ($availablePeople as $person):
                                                    ?>
                                                            <option value="<?= $person['id'] ?>"
                                                                data-fullname="<?= htmlspecialchars($person['fullname']) ?>"
                                                                data-phone="<?= htmlspecialchars($person['phone'] ?? '') ?>"
                                                                data-date="<?= htmlspecialchars($person['date'] ?? '') ?>"
                                                                data-cccd="<?= htmlspecialchars($person['cccd'] ?? '') ?>">
                                                                <?= htmlspecialchars($person['fullname']) ?> -
                                                                <?= htmlspecialchars($person['phone'] ?? 'N/A') ?>
                                                                (<?= $person['total_bookings'] ?? 0 ?> tour)
                                                            </option>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form nhập -->
                                    <div class="person-form-fields">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Họ tên <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-fullname"
                                                        name="peoples[<?= $index ?>][fullname]"
                                                        value="<?= isset($people['fullname']) ? htmlspecialchars($people['fullname']) : '' ?>"
                                                        placeholder="Nguyễn Văn A">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Ngày sinh <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control person-date"
                                                        name="peoples[<?= $index ?>][date]"
                                                        value="<?= isset($people['date']) ? $people['date'] : '' ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>SĐT <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-phone"
                                                        name="peoples[<?= $index ?>][phone]"
                                                        value="<?= isset($people['phone']) ? htmlspecialchars($people['phone']) : '' ?>"
                                                        placeholder="0987654321">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>CCCD <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-cccd"
                                                        name="peoples[<?= $index ?>][cccd]"
                                                        value="<?= isset($people['cccd']) ? htmlspecialchars($people['cccd']) : '' ?>"
                                                        placeholder="001234567890">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Ghi chú<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control person-note"
                                                        name="peoples[<?= $index ?>][note]"
                                                        value="<?= isset($people['note']) ? htmlspecialchars($people['note']) : '' ?>"
                                                        placeholder="Ghi chú">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" class="btn btn-info btn-sm" id="add-people">
                            <i class="fa fa-plus"></i> Thêm khách hàng
                        </button>

                        <!-- Buttons -->
                        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Cập nhật
                            </button>
                            <a href="index.php?act=bookings" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
        'use strict';

        // Khởi tạo biến đếm
        let transportCount = document.querySelectorAll('.transport-item').length;
        let accommodationCount = document.querySelectorAll('.accommodation-item').length;
        let scheduleCount = document.querySelectorAll('.schedule-item').length;
        let peopleCount = document.querySelectorAll('.people-item').length;

        // ===== AUTO-FILL KHI CHỌN TOUR =====
        document.getElementById('tour_id').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (!opt.value) return;

            const data = {
                name: opt.getAttribute('data-name'),
                price: opt.getAttribute('data-price'),
                description: opt.getAttribute('data-description'),
                startDate: opt.getAttribute('data-start'),
                endDate: opt.getAttribute('data-end'),
                schedulesData: opt.getAttribute('data-schedules'),
                categoryId: opt.getAttribute('data-category') // ✅ LẤY CATEGORY
            };

            if (data.name) document.getElementById('name').value = data.name;
            if (data.price) document.getElementById('price').value = data.price;
            if (data.description) document.getElementById('description').value = data.description;
            if (data.startDate) document.getElementById('start_date').value = data.startDate;
            if (data.endDate) document.getElementById('end_date').value = data.endDate;

            // ✅ CẬP NHẬT DANH MỤC
            if (data.categoryId) {
                updateCategoryName(data.categoryId);
            }

            if (data.schedulesData && data.schedulesData !== 'null' && data.schedulesData !== '[]') {
                try {
                    const schedules = JSON.parse(data.schedulesData);
                    if (schedules && Array.isArray(schedules) && schedules.length > 0) {
                        updateSchedules(schedules);
                    }
                } catch (e) {
                    console.error('❌ Lỗi parse schedules:', e);
                }
            }
        });

        // ✅ HÀM CẬP NHẬT TÊN DANH MỤC
        function updateCategoryName(categoryId) {
            // Giả sử bạn có mảng categories từ PHP
            const categories = <?php echo json_encode($allCategory ?? []); ?>;

            const category = categories.find(cat => cat.id == categoryId);
            if (category) {
                document.getElementById('category_id').value = category.name;
            }
        }

        // ===== CẬP NHẬT LỊCH TRÌNH =====
        function updateSchedules(schedules) {
            const container = document.getElementById('schedules-container');
            container.innerHTML = '';

            schedules.forEach((schedule, index) => {
                const html = `
            <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                <h5>Ngày ${index + 1}</h5>
                <input type="hidden" name="schedules[${index}][day_number]" value="${index + 1}">
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Địa điểm</label>
                            <input type="text" class="form-control" name="schedules[${index}][location]" 
                                value="${escapeHtml(schedule.location || '')}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hoạt động</label>
                            <textarea class="form-control" name="schedules[${index}][activities]" rows="2" disabled>${escapeHtml(schedule.activities || '')}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Ghi chú</label>
                    <input type="text" class="form-control" name="schedules[${index}][notes]" 
                        value="${escapeHtml(schedule.notes || '')}" disabled>
                </div>
            </div>
        `;
                container.insertAdjacentHTML('beforeend', html);
            });
            scheduleCount = schedules.length;
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ===== THÊM PHƯƠNG TIỆN =====
        document.getElementById('add-transport')?.addEventListener('click', function() {
            const container = document.getElementById('transports-container');
            const html = `
        <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
            <h5>Phương tiện #${transportCount + 1}</h5>
            
            <!-- THÔNG TIN PHƯƠNG TIỆN -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Loại phương tiện</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][type]" 
                            placeholder="VD: Xe du lịch 45 chỗ">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Số chỗ</label>
                        <input type="number" class="form-control" name="transports[${transportCount}][seats]" 
                            placeholder="45">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Công ty</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][company]" 
                            placeholder="VD: Hoàng Long">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Biển số xe</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][license_plate]" 
                            placeholder="29A-12345">
                    </div>
                </div>
            </div>

            <!-- ĐIỂM TẬP TRUNG -->
            <div class="row" style="background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                <div class="col-md-12">
                    <h6 style="color: #2e7d32; margin-bottom: 10px;">
                        <i class="fa fa-map-marker"></i> Điểm tập trung / Đón khách
                    </h6>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Địa điểm đón <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="transports[${transportCount}][pickup_location]"
                            placeholder="VD: Bến xe Mỹ Đình" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Địa chỉ chi tiết</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][pickup_address]"
                            placeholder="VD: Cổng số 3, Bến xe Mỹ Đình">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Giờ khởi hành <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="transports[${transportCount}][pickup_time]" required>
                    </div>
                </div>
            </div>

            <!-- THÔNG TIN TÀI XẾ -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tên tài xế</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][driver_name]" 
                            placeholder="Nguyễn Văn Tài">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>SĐT tài xế</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][driver_phone]" 
                            placeholder="0123456789">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CCCD tài xế</label>
                        <input type="text" class="form-control" name="transports[${transportCount}][driver_cccd]" 
                            placeholder="001234567890">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" class="form-control" name="transports[${transportCount}][driver_birthdate]">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-danger btn-sm remove-transport">
                <i class="fa fa-trash"></i> Xóa
            </button>
        </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            transportCount++;
            updateRemoveButtons();
        });

        // ===== THÊM KHÁCH SẠN =====
        document.getElementById('add-accommodation')?.addEventListener('click', function() {
            const container = document.getElementById('accommodations-container');
            const html = `
        <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
            <h5>Khách sạn #${accommodationCount + 1}</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" name="accommodations[${accommodationCount}][name]" placeholder="Hạ Long Resort">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Loại</label>
                        <select class="form-control" name="accommodations[${accommodationCount}][type]">
                            <option value="">Chọn</option>
                            <option value="Hotel">Hotel</option>
                            <option value="Resort">Resort</option>
                            <option value="Homestay">Homestay</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="accommodations[${accommodationCount}][address]" placeholder="Bãi Cháy">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>SĐT</label>
                        <input type="text" class="form-control" name="accommodations[${accommodationCount}][sdt]" placeholder="0123456789">
                    </div>
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            accommodationCount++;
            updateRemoveButtons();
        });

        // ===== THÊM KHÁCH HÀNG =====
        document.getElementById('add-people')?.addEventListener('click', function() {
            const maxPeople = parseInt(document.getElementById('max_people')?.value) || 30;
            const currentPeople = document.querySelectorAll('.people-item').length;

            if (currentPeople >= maxPeople) {
                alert(`⚠️ Đã đạt giới hạn ${maxPeople} người!`);
                return;
            }

            const firstSelect = document.querySelector('.person-selector');
            let optionsHtml = '<option value="new">➕ Thêm mới</option>';

            if (firstSelect) {
                Array.from(firstSelect.options).slice(1).forEach(opt => {
                    optionsHtml += `<option value="${opt.value}"
                    data-fullname="${opt.dataset.fullname || ''}"
                    data-phone="${opt.dataset.phone || ''}"
                    data-date="${opt.dataset.date || ''}"
                    data-cccd="${opt.dataset.cccd || ''}">${opt.textContent}</option>`;
                });
            }

            const html = `
        <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
            <h5 style="display: flex; justify-content: space-between;">
                <span>
                    Khách hàng #${peopleCount + 1}
                    <span class="badge person-type-badge" style="background: #5cb85c; font-size: 11px;">Mới</span>
                </span>
                <button type="button" class="btn btn-danger btn-sm remove-people">
                    <i class="fa fa-trash"></i> Xóa
                </button>
            </h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><i class="fa fa-database"></i> Chọn từ danh sách</label>
                        <select class="form-control person-selector" name="peoples[${peopleCount}][existing_id]" data-index="${peopleCount}">
                            ${optionsHtml}
                        </select>
                    </div>
                </div>
            </div>
            <div class="person-form-fields">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control person-fullname" name="peoples[${peopleCount}][fullname]" placeholder="Nguyễn Văn A" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ngày sinh <span class="text-danger">*</span></label>
                            <input type="date" class="form-control person-date" name="peoples[${peopleCount}][date]" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SĐT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control person-phone" name="peoples[${peopleCount}][phone]" placeholder="0987654321" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>CCCD <span class="text-danger">*</span></label>
                            <input type="text" class="form-control person-cccd" name="peoples[${peopleCount}][cccd]" placeholder="001234567890" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
            document.getElementById('people-container').insertAdjacentHTML('beforeend', html);
            peopleCount++;
        });

        // ===== XỬ LÝ KHI CHỌN NGƯỜI =====
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('person-selector')) return;

            const select = e.target;
            const item = select.closest('.people-item');
            const formFields = item.querySelector('.person-form-fields');
            const badge = item.querySelector('.person-type-badge');

            if (select.value === 'new') {
                formFields.style.display = 'block';
                badge.textContent = 'Mới';
                badge.style.backgroundColor = '#5cb85c';

                item.querySelector('.person-fullname').value = '';
                item.querySelector('.person-phone').value = '';
                item.querySelector('.person-date').value = '';
                item.querySelector('.person-cccd').value = '';

                toggleFields(item, false);
            } else {
                const opt = select.options[select.selectedIndex];

                item.querySelector('.person-fullname').value = opt.dataset.fullname || '';
                item.querySelector('.person-phone').value = opt.dataset.phone || '';
                item.querySelector('.person-date').value = opt.dataset.date || '';
                item.querySelector('.person-cccd').value = opt.dataset.cccd || '';

                formFields.style.display = 'none';
                badge.textContent = 'Từ DB';
                badge.style.backgroundColor = '#f0ad4e';

                toggleFields(item, true);
            }
        });

        function toggleFields(item, disabled) {
            const fields = item.querySelectorAll('.person-fullname, .person-phone, .person-date, .person-cccd');
            fields.forEach(field => {
                field.disabled = disabled;
                field.required = !disabled;
            });
        }

        // ===== XÓA ITEMS =====
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-transport') || e.target.closest('.remove-transport')) {
                if (confirm('⚠️ Xác nhận xóa phương tiện này?')) {
                    e.target.closest('.transport-item')?.remove();
                    updateRemoveButtons();
                }
            }
            if (e.target.classList.contains('remove-accommodation') || e.target.closest('.remove-accommodation')) {
                if (confirm('⚠️ Xác nhận xóa khách sạn này?')) {
                    e.target.closest('.accommodation-item')?.remove();
                    updateRemoveButtons();
                }
            }
            if (e.target.classList.contains('remove-people') || e.target.closest('.remove-people')) {
                if (confirm('⚠️ Xác nhận xóa khách hàng này?')) {
                    e.target.closest('.people-item')?.remove();
                }
            }
        });

        // ===== CẬP NHẬT NÚT XÓA =====
        function updateRemoveButtons() {
            // Transports
            const transports = document.querySelectorAll('.transport-item');
            transports.forEach((item, index) => {
                const btn = item.querySelector('.remove-transport');
                if (btn) btn.style.display = index === 0 ? 'none' : 'inline-block';
            });

            // Accommodations
            const accommodations = document.querySelectorAll('.accommodation-item');
            accommodations.forEach((item, index) => {
                const btn = item.querySelector('.remove-accommodation');
                if (btn) btn.style.display = index === 0 ? 'none' : 'block';
            });
        }

        // Gọi lần đầu để cập nhật trạng thái ban đầu
        updateRemoveButtons();

        console.log('✅ Script loaded');
    })();
</script>

<style>
    .person-selector {
        font-weight: 500;
        border: 2px solid #5bc0de;
    }

    .person-form-fields {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px dashed #5bc0de;
    }

    .person-type-badge {
        padding: 4px 10px;
        border-radius: 3px;
    }

    input:disabled,
    select:disabled {
        background-color: #e9ecef !important;
        cursor: not-allowed;
    }
</style>

<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
?>