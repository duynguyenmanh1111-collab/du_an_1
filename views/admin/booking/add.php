<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Thêm booking mới</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form tạo booking mới</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=bookings-create" enctype="multipart/form-data">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên tour" disabled>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" disabled>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($allCategory as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Ngày bắt đầu và Ngày kết thúc -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                        </div>
                        <!-- Điểm đến (Tour) -->
                        <div class="form-group">
                            <label for="tour_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="tour_id" name="tour_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php foreach ($allTour as $tour):
                                    // Lấy schedules của tour
                                    $tourSchedules = [];
                                    if (isset($tour['schedules'])) {
                                        $tourSchedules = is_string($tour['schedules'])
                                            ? json_decode($tour['schedules'], true)
                                            : $tour['schedules'];
                                    }
                                ?>
                                    <option value="<?= $tour['id'] ?>"
                                        data-name="<?= htmlspecialchars($tour['name']) ?>"
                                        data-price="<?= $tour['price'] ?>"
                                        data-description="<?= htmlspecialchars($tour['description'] ?? '') ?>"
                                        data-category="<?= $tour['category_id'] ?>"
                                        data-schedules='<?= htmlspecialchars(json_encode($tourSchedules ?: []), ENT_QUOTES, 'UTF-8') ?>'>
                                        <?= htmlspecialchars($tour['name']) ?> - <?= number_format($tour['price']) ?> VNĐ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Hướng Dẫn Viên -->
                        <div class="form-group">
                            <label for="guide_id">
                                Hướng Dẫn Viên <span class="text-danger">*</span>
                                <small class="text-muted" id="guide-status"></small>
                            </label>
                            <select class="form-control" id="guide_id" name="guide_id" required>
                                <option value="">-- Chọn Hướng Dẫn Viên --</option>
                                <?php foreach ($allGuide as $gui): ?>
                                    <option value="<?= $gui['id'] ?>"
                                        data-phone="<?= htmlspecialchars($gui['phone'] ?? '') ?>"
                                        data-email="<?= htmlspecialchars($gui['email'] ?? '') ?>">
                                        <?= htmlspecialchars($gui['full_name']) ?>
                                        <?php if (!empty($gui['phone'])): ?>
                                            (<?= htmlspecialchars($gui['phone']) ?>)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div id="guide-conflict-warning" class="alert alert-danger" style="display: none; margin-top: 10px;">
                                <i class="fa fa-exclamation-triangle"></i>
                                <strong>⚠️ Hướng dẫn viên bị trùng lịch!</strong>
                                <ul id="guide-conflict-list"></ul>
                                <small class="text-muted">Vui lòng chọn hướng dẫn viên khác hoặc thay đổi ngày tour.</small>
                            </div>

                            <small class="text-info">
                                <i class="fa fa-info-circle"></i>
                                Chọn ngày bắt đầu và kết thúc trước để kiểm tra trùng lịch
                            </small>
                        </div>



                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả tour" disabled></textarea>
                        </div>

                        <!-- Yêu cầu đặc biệt -->
                        <div class="form-group">
                            <label for="special_request">Yêu cầu đặc biệt</label>
                            <textarea class="form-control" id="special_request" name="special_request" rows="4"
                                placeholder="Nhập yêu cầu đặc biệt"></textarea>
                        </div>



                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Nhập giá tour" min="0" disabled>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" selected>Chờ khởi hành</option>
                                <option value="confirmed">Đang khởi hành</option>
                                <option value="cancelled">Đã hủy</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>

                        <!-- Số chỗ tối đa -->
                        <div class="form-group">
                            <label for="max_people">Số chỗ tối đa <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="max_people" name="max_people"
                                placeholder="Nhập số chỗ tối đa (VD: 30)" min="1" max="999" required>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i> Giới hạn số người tối đa có thể tham gia tour này
                            </small>
                        </div>

                        <!-- PHƯƠNG TIỆN -->
                        <h4 class="text-success" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5cb85c; padding-bottom: 10px;">
                            <i class="fa fa-bus"></i> Phương tiện di chuyển
                        </h4>

                        <div id="transports-container">
                            <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
                                <h5 style="margin-top: 0;">Phương tiện #1</h5>

                                <!-- THÔNG TIN PHƯƠNG TIỆN -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loại phương tiện</label>
                                            <input type="text" class="form-control" name="transports[0][type]"
                                                placeholder="VD: Xe du lịch 45 chỗ">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Số chỗ</label>
                                            <input type="number" class="form-control" name="transports[0][seats]"
                                                placeholder="45">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Công ty</label>
                                            <input type="text" class="form-control" name="transports[0][company]"
                                                placeholder="VD: Hoàng Long">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Biển số xe</label>
                                            <input type="text" class="form-control" name="transports[0][license_plate]"
                                                placeholder="29A-12345">
                                        </div>
                                    </div>
                                </div>



                                <!-- THÔNG TIN TÀI XẾ -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tên tài xế</label>
                                            <input type="text" class="form-control" name="transports[0][driver_name]"
                                                placeholder="Nguyễn Văn Tài">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>SĐT tài xế</label>
                                            <input type="text" class="form-control" name="transports[0][driver_phone]"
                                                placeholder="0123456789">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>CCCD tài xế</label>
                                            <input type="text" class="form-control" name="transports[0][driver_cccd]"
                                                placeholder="001234567890">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Ngày sinh</label>
                                            <input type="date" class="form-control" name="transports[0][driver_birthdate]">
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
                                            <input type="text" class="form-control" name="transports[0][pickup_location]"
                                                placeholder="VD: Bến xe Mỹ Đình"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Địa chỉ chi tiết</label>
                                            <input type="text" class="form-control" name="transports[0][pickup_address]"
                                                placeholder="VD: Cổng số 3, Bến xe Mỹ Đình, Nam Từ Liêm, Hà Nội">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Giờ khởi hành <span class="text-danger">*</span></label>
                                            <input type="time" class="form-control" name="transports[0][pickup_time]"
                                                placeholder="06:00"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-transport" style="display:none;">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="add-transport">
                            <i class="fa fa-plus"></i> Thêm phương tiện
                        </button>

                        <!-- KHÁCH SẠN -->
                        <h4 class="text-warning" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #f0ad4e; padding-bottom: 10px;">
                            <i class="fa fa-hotel"></i> Khách sạn / Nơi lưu trú
                        </h4>

                        <div id="accommodations-container">
                            <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
                                <h5 style="margin-top: 0;">Khách sạn #1</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tên khách sạn</label>
                                            <input type="text" class="form-control" name="accommodations[0][name]"
                                                placeholder="VD: Hạ Long Bay Resort">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Loại</label>
                                            <select class="form-control" name="accommodations[0][type]">
                                                <option value="">Chọn loại</option>
                                                <option value="Hotel">Hotel</option>
                                                <option value="Resort">Resort</option>
                                                <option value="Homestay">Homestay</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input type="text" class="form-control" name="accommodations[0][address]"
                                                placeholder="VD: Bãi Cháy, Quảng Ninh">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control" name="accommodations[0][sdt]"
                                                placeholder="0123456789">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation" style="display:none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm" id="add-accommodation">
                            <i class="fa fa-plus"></i> Thêm khách sạn
                        </button>
                        <!-- LỊCH TRÌNH -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-calendar"></i> Lịch trình chi tiết
                        </h4>

                        <div id="schedules-container">
                            <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                <h5 style="margin-top: 0;">Ngày 1</h5>
                                <input type="hidden" name="schedules[0][day_number]" value="1">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Địa điểm</label>
                                            <input type="text" class="form-control" name="schedules[0][location]"
                                                placeholder="VD: Hà Nội - Hạ Long" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Hoạt động</label>
                                            <textarea class="form-control" name="schedules[0][activities]" rows="2"
                                                placeholder="Mô tả hoạt động trong ngày" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm form-control remove-schedule" style="display:none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <input type="text" class="form-control" name="schedules[0][notes]"
                                        placeholder="VD: Mang theo CMND/CCCD" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- KHÁCH HÀNG -->
                        <!-- KHÁCH HÀNG -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-users"></i> Danh sách khách hàng tham gia
                        </h4>

                        <div id="people-container">
                            <div class="people-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                <h5 style="margin-top: 0; display: flex; justify-content: space-between;">
                                    <span>
                                        Khách hàng #1
                                        <span class="badge person-type-badge" style="background: #5cb85c; font-size: 11px;">Mới</span>
                                    </span>
                                    <button type="button" class="btn btn-danger btn-sm remove-people" style="display:none;">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </h5>

                                <!-- ✅ LUÔN HIỂN THỊ DROPDOWN (dù rỗng) -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>
                                                <i class="fa fa-database"></i> Chọn từ danh sách
                                                <small class="text-muted" id="people-selector-hint">(Chọn ngày để xem danh sách)</small>
                                            </label>
                                            <select class="form-control person-selector" name="peoples[0][existing_id]" data-index="0">
                                                <option value="new">➕ Thêm mới</option>
                                                <?php if (!empty($availablePeople)): ?>
                                                    <?php foreach ($availablePeople as $person): ?>
                                                        <option value="<?= $person['id'] ?>"
                                                            data-fullname="<?= htmlspecialchars($person['fullname']) ?>"
                                                            data-phone="<?= htmlspecialchars($person['phone'] ?? '') ?>"
                                                            data-date="<?= htmlspecialchars($person['date'] ?? '') ?>"
                                                            data-cccd="<?= htmlspecialchars($person['cccd'] ?? '') ?>">
                                                            <?= htmlspecialchars($person['fullname']) ?> -
                                                            <?= htmlspecialchars($person['phone'] ?? 'N/A') ?>
                                                            (<?= $person['total_bookings'] ?? 0 ?> tour)
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <!-- FORM NHẬP -->
                                <div class="person-form-fields">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Tên</label>
                                                <input type="text" class="form-control person-fullname"
                                                    name="peoples[0][fullname]"
                                                    placeholder="Họ tên"
                                                    required> <!-- ✅ THÊM DÒNG NÀY -->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ngày sinh</label>
                                                <input type="date" class="form-control person-date"
                                                    name="peoples[0][date]"
                                                    required> <!-- ✅ THÊM DÒNG NÀY -->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" class="form-control person-phone"
                                                    name="peoples[0][phone]"
                                                    placeholder="0987654321"
                                                    required> <!-- ✅ THÊM DÒNG NÀY -->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>CCCD</label>
                                                <input type="text" class="form-control person-cccd"
                                                    name="peoples[0][cccd]"
                                                    placeholder="123456789"
                                                    required> <!-- ✅ THÊM DÒNG NÀY -->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control person-note"
                                                    name="peoples[0][note]"
                                                    placeholder="Ghi chú">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-people">
                            <i class="fa fa-plus"></i> Thêm khách hàng
                        </button>

                        <!-- Buttons -->
                        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Tạo Booking
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
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("start_date").setAttribute("min", today);
        });
        // Khởi tạo biến đếm
        let transportCount = document.querySelectorAll('.transport-item').length;
        let accommodationCount = document.querySelectorAll('.accommodation-item').length;
        let scheduleCount = document.querySelectorAll('.schedule-item').length;
        let peopleCount = document.querySelectorAll('.people-item').length;

        const startDateEl = document.getElementById('start_date');
        const endDateEl = document.getElementById('end_date');
        const guideSelect = document.getElementById('guide_id');
        const guideStatus = document.getElementById('guide-status');
        const guideConflictWarning = document.getElementById('guide-conflict-warning');
        const guideConflictList = document.getElementById('guide-conflict-list');

        let conflictedGuides = new Set();

        // ===== AUTO-FILL KHI CHỌN TOUR =====
        document.getElementById('tour_id').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (!opt.value) return;

            const data = {
                name: opt.getAttribute('data-name'),
                price: opt.getAttribute('data-price'),
                description: opt.getAttribute('data-description'),
                category: opt.getAttribute('data-category'),
                schedulesData: opt.getAttribute('data-schedules')
            };

            if (data.name) document.getElementById('name').value = data.name;
            if (data.price) document.getElementById('price').value = data.price;
            if (data.description) document.getElementById('description').value = data.description;
            if (data.category) document.getElementById('category_id').value = data.category;

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

        function updateSchedules(schedules) {
            const container = document.getElementById('schedules-container');
            container.innerHTML = '';

            schedules.forEach((schedule, index) => {
                const html = `
            <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                <h5>Ngày ${index + 1}</h5>
                <input type="hidden" name="schedules[${index}][day_number]" value="${index + 1}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ngày</label>
                            <input type="date" class="form-control" name="schedules[${index}][date]" 
                                value="${schedule.date || ''}" disabled>
                        </div>
                    </div>
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

        // ===== ✅ HIỂN THỊ THÔNG BÁO ĐANG TẢI =====
        function showLoadingNotification() {
            const oldNotif = document.getElementById('loading-notification');
            if (oldNotif) oldNotif.remove();

            const notification = document.createElement('div');
            notification.id = 'loading-notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #5bc0de;
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease-out;
            `;
            notification.innerHTML = `
                <i class="fa fa-spinner fa-spin"></i>
                <strong>Đang tải danh sách HDV và khách hàng...</strong>
            `;
            document.body.appendChild(notification);
        }

        // ===== ✅ HIỂN THỊ THÔNG BÁO THÀNH CÔNG =====
        function showSuccessNotification(guideCount, peopleCount) {
            const oldNotif = document.getElementById('loading-notification');
            if (oldNotif) oldNotif.remove();

            const notification = document.createElement('div');
            notification.id = 'success-notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #5cb85c;
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease-out;
            `;
            notification.innerHTML = `
                <i class="fa fa-check-circle"></i>
                <strong>Thành công!</strong><br>
                <small>✅ ${guideCount} HDV có sẵn<br>✅ ${peopleCount} khách hàng có sẵn</small>
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // ===== ✅ KIỂM TRA KHI ĐỔI NGÀY - GỌI API =====
        if (startDateEl && endDateEl) { // ✅ CHECK TRƯỚC KHI DÙNG
            let debounceTimer;

            function handleDateChange() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const startDate = startDateEl.value;
                    const endDate = endDateEl.value;

                    if (startDate && endDate) {
                        console.log('🔄 Đang load danh sách...', {
                            startDate,
                            endDate
                        });
                        showLoadingNotification();
                        loadAvailableData(startDate, endDate);
                    }
                }, 300);
            }

            startDateEl.addEventListener('change', handleDateChange);
            endDateEl.addEventListener('change', handleDateChange);
        }

        // ===== ✅ LOAD DANH SÁCH HDV VÀ NGƯỜI BẰNG AJAX =====
        function loadAvailableData(startDate, endDate) {
            let guidesLoaded = false;
            let peopleLoaded = false;
            let guidesData = [];
            let peopleData = [];

            // 1. Load HDV
            fetch(`index.php?act=get-available-guides-api&start_date=${startDate}&end_date=${endDate}`)
                .then(res => {
                    console.log('📡 HDV status:', res.status, res.headers.get('content-type'));

                    // ✅ CHECK NẾU KHÔNG PHẢI JSON
                    const contentType = res.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('❌ API trả về HTML thay vì JSON. Kiểm tra PHP errors.');
                    }

                    return res.json();
                })
                .then(data => {
                    console.log('✅ HDV data:', data);
                    if (data.success) {
                        guidesData = data.data;
                        updateGuideOptions(data.data);
                    }
                    guidesLoaded = true;
                    checkAndShowSuccess();
                })
                .catch(err => {
                    console.error('❌ Lỗi load HDV:', err);
                    alert('⚠️ Không thể load danh sách HDV: ' + err.message);
                    guidesLoaded = true;
                    checkAndShowSuccess();
                });

            // 2. Load Người
            fetch(`index.php?act=get-available-people-api&start_date=${startDate}&end_date=${endDate}`)
                .then(res => {
                    console.log('📡 People status:', res.status, res.headers.get('content-type'));

                    const contentType = res.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('❌ API trả về HTML thay vì JSON. Kiểm tra PHP errors.');
                    }

                    return res.json();
                })
                .then(data => {
                    console.log('✅ People data:', data);
                    if (data.success) {
                        peopleData = data.data;
                        updatePeopleOptions(data.data);
                    }
                    peopleLoaded = true;
                    checkAndShowSuccess();
                })
                .catch(err => {
                    console.error('❌ Lỗi load người:', err);
                    alert('⚠️ Không thể load danh sách khách hàng: ' + err.message);
                    peopleLoaded = true;
                    checkAndShowSuccess();
                });

            function checkAndShowSuccess() {
                if (guidesLoaded && peopleLoaded) {
                    showSuccessNotification(guidesData.length, peopleData.length);
                }
            }
        }

        // ===== ✅ CẬP NHẬT DROPDOWN HDV =====
        function updateGuideOptions(guides) {
            if (!guideSelect) {
                console.error('❌ Không tìm thấy #guide_id');
                return;
            }

            const currentValue = guideSelect.value;
            const allOptions = Array.from(guideSelect.options).slice(1);
            const availableIds = guides.map(g => g.id.toString());

            console.log('📋 Đang cập nhật HDV:', {
                total: allOptions.length,
                available: availableIds.length,
                currentValue
            });

            allOptions.forEach(option => {
                const guideId = option.value;

                if (availableIds.includes(guideId)) {
                    option.disabled = false;
                    option.style.color = '';
                    option.style.display = '';
                    option.textContent = option.textContent.replace(' [Bận]', '').replace(' [Không khả dụng]', '');
                } else {
                    option.disabled = true;
                    option.style.color = '#999';
                    option.style.display = 'none'; // ✅ ẨN LUÔN
                    if (!option.textContent.includes('[Bận]')) {
                        option.textContent += ' [Bận]';
                    }
                }
            });

            if (currentValue && availableIds.includes(currentValue)) {
                guideSelect.value = currentValue;
            } else if (currentValue) {
                guideSelect.value = '';
                console.warn('⚠️ HDV đã chọn không còn available');
            }
        }

        // ===== ✅ CẬP NHẬT DROPDOWN NGƯỜI =====
        // ===== ✅ CẬP NHẬT DROPDOWN NGƯỜI =====
        function updatePeopleOptions(people) {
            const selectors = document.querySelectorAll('.person-selector');

            if (selectors.length === 0) {
                console.warn('⚠️ Không tìm thấy .person-selector');
                return;
            }

            console.log('📋 Đang cập nhật', selectors.length, 'dropdowns với', people.length, 'người');

            // ✅ CẬP NHẬT HINT TEXT
            const hint = document.getElementById('people-selector-hint');
            if (hint) {
                if (people && people.length > 0) {
                    hint.textContent = `(${people.length} người có sẵn)`;
                    hint.style.color = '#5cb85c';
                } else {
                    hint.textContent = '(Không có người nào khả dụng)';
                    hint.style.color = '#d9534f';
                }
            }

            selectors.forEach(select => {
                const currentValue = select.value;

                // ✅ XÓA TẤT CẢ OPTIONS TRỪ "THÊM MỚI"
                while (select.options.length > 1) {
                    select.remove(1);
                }

                // ✅ THÊM NGƯỜI MỚI
                if (people && people.length > 0) {
                    people.forEach(person => {
                        const option = document.createElement('option');
                        option.value = person.id;
                        option.textContent = `${person.fullname} - ${person.phone || 'N/A'} (${person.total_bookings || 0} tour)`;

                        // ✅ LƯU DATA VÀO DATASET
                        option.dataset.fullname = person.fullname || '';
                        option.dataset.phone = person.phone || '';
                        option.dataset.date = person.date || '';
                        option.dataset.cccd = person.cccd || '';

                        select.appendChild(option);
                    });

                    console.log(`✅ Đã thêm ${people.length} người vào dropdown`);
                } else {
                    console.log('ℹ️ Không có người nào để thêm');
                }

                // ✅ KHÔI PHỤC GIÁ TRỊ ĐÃ CHỌN (nếu còn available)
                if (currentValue && currentValue !== 'new') {
                    const exists = Array.from(select.options).some(opt => opt.value === currentValue);
                    if (exists) {
                        select.value = currentValue;
                    } else {
                        select.value = 'new';
                        console.warn('⚠️ Người đã chọn không còn available');
                    }
                }
            });

            console.log('✅ Đã cập nhật tất cả dropdowns người');
        }

        // ===== KIỂM TRA TRÙNG LỊCH HDV =====
        if (guideSelect) {
            guideSelect.addEventListener('change', function() {
                checkGuideConflict(this.value);
            });
        }

        function checkGuideConflict(guideId) {
            if (!guideId) {
                if (guideConflictWarning) guideConflictWarning.style.display = 'none';
                if (guideStatus) guideStatus.textContent = '';
                return;
            }

            const startDate = startDateEl?.value;
            const endDate = endDateEl?.value;

            if (!startDate || !endDate) {
                if (guideStatus) {
                    guideStatus.innerHTML = '<span style="color: orange;">(Chọn ngày để kiểm tra)</span>';
                }
                return;
            }

            if (guideStatus) {
                guideStatus.innerHTML = '<span style="color: blue;"><i class="fa fa-spinner fa-spin"></i> Đang kiểm tra...</span>';
            }

            fetch(`index.php?act=check-guide-conflict-api&guide_id=${guideId}&start_date=${startDate}&end_date=${endDate}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (data.has_conflict) {
                            if (guideStatus) {
                                guideStatus.innerHTML = '<span style="color: red;"><i class="fa fa-times-circle"></i> Bị trùng lịch!</span>';
                            }
                            if (guideConflictWarning) {
                                guideConflictWarning.style.display = 'block';
                            }
                            if (guideConflictList) {
                                guideConflictList.innerHTML = data.conflicts.map(c =>
                                    `<li><strong>Tour:</strong> ${c.tour_name}<br><strong>Ngày:</strong> ${c.start_date} → ${c.end_date}</li>`
                                ).join('');
                            }
                            conflictedGuides.add(guideId);
                        } else {
                            if (guideStatus) {
                                guideStatus.innerHTML = '<span style="color: green;"><i class="fa fa-check-circle"></i> Có thể chọn</span>';
                            }
                            if (guideConflictWarning) {
                                guideConflictWarning.style.display = 'none';
                            }
                            conflictedGuides.delete(guideId);
                        }
                    }
                })
                .catch(err => {
                    console.error('❌ Lỗi kiểm tra HDV:', err);
                    if (guideStatus) {
                        guideStatus.innerHTML = '';
                    }
                });
        }

        // ===== THÊM PHƯƠNG TIỆN =====
        document.getElementById('add-transport')?.addEventListener('click', function() {
            const container = document.getElementById('transports-container');
            const html = `
    <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
        <h5 style="margin-top: 0;">Phương tiện #${transportCount + 1}</h5>
        
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
                    <input type="text" class="form-control" name="transports[${transportCount}][pickup_location]"
                        placeholder="VD: Bến xe Mỹ Đình"
                        required>
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
                    <input type="time" class="form-control" name="transports[${transportCount}][pickup_time]"
                        required>
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

        // ===== XÓA PHƯƠNG TIỆN =====
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-transport') || e.target.closest('.remove-transport')) {
                if (confirm('⚠️ Xác nhận xóa phương tiện này?')) {
                    e.target.closest('.transport-item')?.remove();
                    updateRemoveButtons();
                }
            }
        });

        // ===== CẬP NHẬT NÚT XÓA =====
        function updateRemoveButtons() {
            // Transports
            const transports = document.querySelectorAll('.transport-item');
            if (transports.length > 1) {
                transports.forEach(item => {
                    const btn = item.querySelector('.remove-transport');
                    if (btn) btn.style.display = 'inline-block';
                });
            } else if (transports.length === 1) {
                const btn = transports[0].querySelector('.remove-transport');
                if (btn) btn.style.display = 'none';
            }

            // Accommodations (giữ nguyên logic cũ)
            const accommodations = document.querySelectorAll('.accommodation-item');
            if (accommodations.length > 1) {
                accommodations.forEach(item => {
                    const btn = item.querySelector('.remove-accommodation');
                    if (btn) btn.style.display = 'block';
                });
            } else if (accommodations.length === 1) {
                const btn = accommodations[0].querySelector('.remove-accommodation');
                if (btn) btn.style.display = 'none';
            }
        }

        // ===== THÊM KHÁCH SẠN =====
        document.getElementById('add-accommodation')?.addEventListener('click', function() {
            const container = document.getElementById('accommodations-container');
            const html = `
    <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
        <h5 style="margin-top: 0;">Khách sạn #${accommodationCount + 1}</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tên khách sạn</label>
                    <input type="text" class="form-control" name="accommodations[${accommodationCount}][name]"
                        placeholder="VD: Hạ Long Bay Resort">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Loại</label>
                    <select class="form-control" name="accommodations[${accommodationCount}][type]">
                        <option value="">Chọn loại</option>
                        <option value="Hotel">Hotel</option>
                        <option value="Resort">Resort</option>
                        <option value="Homestay">Homestay</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" class="form-control" name="accommodations[${accommodationCount}][address]"
                        placeholder="VD: Bãi Cháy, Quảng Ninh">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" class="form-control" name="accommodations[${accommodationCount}][sdt]"
                        placeholder="0123456789">
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

            // ✅ Hiển thị nút xóa cho item đầu tiên khi có >= 2 items
            updateRemoveButtons();
        });

        // ===== XÓA KHÁCH SẠN =====
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-accommodation') || e.target.closest('.remove-accommodation')) {
                if (confirm('⚠️ Xác nhận xóa khách sạn này?')) {
                    e.target.closest('.accommodation-item')?.remove();
                    updateRemoveButtons();
                }
            }
        });

        // ===== CẬP NHẬT NÚT XÓA =====
        function updateRemoveButtons() {
            // Accommodations
            const accommodations = document.querySelectorAll('.accommodation-item');
            if (accommodations.length > 1) {
                accommodations.forEach(item => {
                    const btn = item.querySelector('.remove-accommodation');
                    if (btn) btn.style.display = 'block';
                });
            } else if (accommodations.length === 1) {
                const btn = accommodations[0].querySelector('.remove-accommodation');
                if (btn) btn.style.display = 'none';
            }
        }

        // ===== ✅ THÊM KHÁCH HÀNG =====
        // ===== ✅ THÊM KHÁCH HÀNG =====
        document.getElementById('add-people')?.addEventListener('click', function() {
            const maxPeople = parseInt(document.getElementById('max_people')?.value) || 30;
            const currentPeople = document.querySelectorAll('.people-item').length;

            if (currentPeople >= maxPeople) {
                alert(`⚠️ Đã đạt giới hạn ${maxPeople} người!`);
                return;
            }

            const firstSelect = document.querySelector('.person-selector');
            let optionsHtml = '<option value="new">➕ Thêm mới</option>';

            if (firstSelect && firstSelect.options.length > 1) {
                Array.from(firstSelect.options).slice(1).forEach(opt => {
                    const fullname = (opt.dataset.fullname || '').replace(/"/g, '&quot;');
                    const phone = (opt.dataset.phone || '').replace(/"/g, '&quot;');
                    const date = (opt.dataset.date || '').replace(/"/g, '&quot;');
                    const cccd = (opt.dataset.cccd || '').replace(/"/g, '&quot;');
                    const text = opt.textContent.replace(/"/g, '&quot;');

                    optionsHtml += `<option value="${opt.value}" data-fullname="${fullname}" data-phone="${phone}" data-date="${date}" data-cccd="${cccd}">${text}</option>`;
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ghi chú <span class="text-danger">*</span></label>
                        <input type="text" class="form-control person-note" name="peoples[${peopleCount}][note]" placeholder="Ghi chú" required>
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
                e.target.closest('.transport-item')?.remove();
            }
            if (e.target.classList.contains('remove-accommodation') || e.target.closest('.remove-accommodation')) {
                e.target.closest('.accommodation-item')?.remove();
            }
            if (e.target.classList.contains('remove-people') || e.target.closest('.remove-people')) {
                if (confirm('⚠️ Xác nhận xóa?')) {
                    e.target.closest('.people-item')?.remove();
                }
            }
        });

        // ===== NGĂN SUBMIT NẾU HDV BỊ TRÙNG =====
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const selectedGuideId = guideSelect?.value;

            if (selectedGuideId && conflictedGuides.has(selectedGuideId)) {
                e.preventDefault();
                alert('⚠️ Không thể tạo booking!\n\nHướng dẫn viên đã chọn bị trùng lịch.\nVui lòng chọn hướng dẫn viên khác hoặc thay đổi ngày tour.');
                guideSelect.focus();
                return false;
            }
        });

        console.log('✅ Script loaded');
    })();
</script>
<style>
    /* ✅ ANIMATION CHO NOTIFICATION */
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    html,
    body {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    /* ✅ CSS CHO HDV */
    #guide_id option:disabled {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        display: none !important;
        /* ẨN LUÔN HDV BẬN */
    }

    #guide-conflict-warning {
        animation: shake 0.5s;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    #guide-conflict-list li {
        margin-bottom: 10px;
        padding: 8px;
        background: #fff3cd;
        border-left: 3px solid #ffc107;
        border-radius: 3px;
    }

    /* ✅ CSS CHO NGƯỜI */
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