<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Booking mới</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=bookings-create" method="POST" id="bookingForm">
        <div class="card-body">
            <!-- Thông tin cơ bản -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tour <span class="text-danger">*</span></label>
                        <select name="tour_id" class="form-select" required>
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($tours as $tour): ?>
                            <option value="<?= $tour['id'] ?>"><?= htmlspecialchars($tour['name']) ?> - <?= number_format($tour['price'] ?? 0, 0, ',', '.') ?> VNĐ</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Hướng dẫn viên</label>
                        <select name="guide_id" class="form-select" id="guide_id">
                            <option value="">-- Chọn HDV --</option>
                            <?php foreach ($guides as $guide): ?>
                            <option value="<?= $guide['id'] ?>"><?= htmlspecialchars($guide['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="guide-warning" class="text-warning small mt-1" style="display:none;"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" id="start_date" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" id="end_date" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Số người tối đa</label>
                        <input type="number" name="max_people" class="form-control" value="10" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Số người đi</label>
                        <span class="form-control bg-light" id="people-count">0</span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Yêu cầu đặc biệt</label>
                <textarea name="special_request" class="form-control" rows="2"></textarea>
            </div>

            <!-- Phương tiện -->
            <h5 class="mt-4 mb-3"><i class="bi bi-truck"></i> Phương tiện di chuyển</h5>
            <div id="transports-container">
                <div class="card mb-2 transport-item">
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Loại</label>
                                <select name="transports[0][type]" class="form-select form-select-sm">
                                    <option value="">-- Chọn --</option>
                                    <option value="bus">Xe bus</option>
                                    <option value="car">Xe ô tô</option>
                                    <option value="plane">Máy bay</option>
                                    <option value="train">Tàu hỏa</option>
                                    <option value="boat">Tàu thủy</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Công ty</label>
                                <input type="text" name="transports[0][company]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Số chỗ</label>
                                <input type="number" name="transports[0][seats]" class="form-control form-control-sm" min="1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="transports[0][notes]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-transport" style="display:none;"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-transport" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-plus"></i> Thêm phương tiện
            </button>

            <!-- Khách sạn -->
            <h5 class="mt-3 mb-3"><i class="bi bi-building"></i> Nơi lưu trú</h5>
            <div id="accommodations-container">
                <div class="card mb-2 accommodation-item">
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Tên khách sạn</label>
                                <input type="text" name="accommodations[0][name]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Loại phòng</label>
                                <select name="accommodations[0][type]" class="form-select form-select-sm">
                                    <option value="">-- Chọn --</option>
                                    <option value="single">Đơn</option>
                                    <option value="double">Đôi</option>
                                    <option value="suite">Suite</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="accommodations[0][address]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="accommodations[0][notes]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-accommodation" style="display:none;"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-accommodation" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-plus"></i> Thêm nơi lưu trú
            </button>

            <!-- Danh sách khách -->
            <h5 class="mt-3 mb-3"><i class="bi bi-people"></i> Danh sách khách</h5>
            <div id="peoples-container">
                <div class="card mb-2 people-item">
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="peoples[0][fullname]" class="form-control form-control-sm people-fullname">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="peoples[0][date]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">SĐT</label>
                                <input type="text" name="peoples[0][phone]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">CCCD</label>
                                <input type="text" name="peoples[0][cccd]" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Giới tính</label>
                                <select name="peoples[0][gender]" class="form-select form-select-sm">
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-people" style="display:none;"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-people" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-plus"></i> Thêm khách
            </button>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu Booking</button>
            <a href="<?= BASE_URL ?>?act=bookings" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<script>
let transportIndex = 1, accommodationIndex = 1, peopleIndex = 1;

// Add transport
document.getElementById('add-transport').addEventListener('click', function() {
    const container = document.getElementById('transports-container');
    const html = `
        <div class="card mb-2 transport-item">
            <div class="card-body py-2">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Loại</label>
                        <select name="transports[${transportIndex}][type]" class="form-select form-select-sm">
                            <option value="">-- Chọn --</option>
                            <option value="bus">Xe bus</option>
                            <option value="car">Xe ô tô</option>
                            <option value="plane">Máy bay</option>
                            <option value="train">Tàu hỏa</option>
                            <option value="boat">Tàu thủy</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Công ty</label>
                        <input type="text" name="transports[${transportIndex}][company]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Số chỗ</label>
                        <input type="number" name="transports[${transportIndex}][seats]" class="form-control form-control-sm" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ghi chú</label>
                        <input type="text" name="transports[${transportIndex}][notes]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-transport"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    transportIndex++;
});

// Add accommodation
document.getElementById('add-accommodation').addEventListener('click', function() {
    const container = document.getElementById('accommodations-container');
    const html = `
        <div class="card mb-2 accommodation-item">
            <div class="card-body py-2">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Tên khách sạn</label>
                        <input type="text" name="accommodations[${accommodationIndex}][name]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Loại phòng</label>
                        <select name="accommodations[${accommodationIndex}][type]" class="form-select form-select-sm">
                            <option value="">-- Chọn --</option>
                            <option value="single">Đơn</option>
                            <option value="double">Đôi</option>
                            <option value="suite">Suite</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="accommodations[${accommodationIndex}][address]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ghi chú</label>
                        <input type="text" name="accommodations[${accommodationIndex}][notes]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-accommodation"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    accommodationIndex++;
});

// Add people
document.getElementById('add-people').addEventListener('click', function() {
    const container = document.getElementById('peoples-container');
    const html = `
        <div class="card mb-2 people-item">
            <div class="card-body py-2">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="peoples[${peopleIndex}][fullname]" class="form-control form-control-sm people-fullname">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="peoples[${peopleIndex}][date]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">SĐT</label>
                        <input type="text" name="peoples[${peopleIndex}][phone]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">CCCD</label>
                        <input type="text" name="peoples[${peopleIndex}][cccd]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Giới tính</label>
                        <select name="peoples[${peopleIndex}][gender]" class="form-select form-select-sm">
                            <option value="male">Nam</option>
                            <option value="female">Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-people"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    peopleIndex++;
    updatePeopleCount();
});

// Remove items
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-transport')) e.target.closest('.transport-item').remove();
    if (e.target.closest('.remove-accommodation')) e.target.closest('.accommodation-item').remove();
    if (e.target.closest('.remove-people')) {
        e.target.closest('.people-item').remove();
        updatePeopleCount();
    }
});

function updatePeopleCount() {
    document.getElementById('people-count').textContent = document.querySelectorAll('.people-item').length;
}
updatePeopleCount();
</script>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Thêm Booking',
    'pageTitle' => 'Thêm Booking mới',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Booking', 'url' => BASE_URL . '?act=bookings'],
        ['label' => 'Thêm mới', 'active' => true]
    ]
]);
?>
