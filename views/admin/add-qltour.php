<?php
require_once __DIR__ . '/../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Thêm mới Tour</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form thêm mới Tour:</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=createTour" enctype="multipart/form-data">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên tour" required>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php if (isset($allCategory) && is_array($allCategory)): ?>
                                    <?php foreach ($allCategory as $category): ?>
                                        <option value="<?php echo $category['id']; ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Điểm đến -->
                        <div class="form-group">
                            <label for="destination_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="destination_id" name="destination_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php if (isset($allDestination) && is_array($allDestination)): ?>
                                    <?php foreach ($allDestination as $destination): ?>
                                        <option value="<?php echo $destination['id']; ?>">
                                            <?php echo htmlspecialchars($destination['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                placeholder="Nhập mô tả tour"></textarea>
                        </div>

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
                                                placeholder="VD: Hà Nội - Hạ Long">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Hoạt động</label>
                                            <textarea class="form-control" name="schedules[0][activities]" rows="2"
                                                placeholder="Mô tả hoạt động trong ngày"></textarea>
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
                                        placeholder="VD: Mang theo CMND/CCCD">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-schedule">
                            <i class="fa fa-plus"></i> Thêm ngày
                        </button>

                        <!-- Giá -->
                        <div class="form-group" style="margin-top: 20px;">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Nhập giá tour" min="0" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="open">Mở đăng ký</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Thêm mới Tour
                            </button>
                            <a href="index.php?act=QlTour" class="btn btn-default">
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
    let scheduleCount = 1;

    // Thêm lịch trình
    document.getElementById('add-schedule').addEventListener('click', function() {
        const container = document.getElementById('schedules-container');
        const newItem = `
        <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
            <h5 style="margin-top: 0;">Ngày ${scheduleCount + 1}</h5>
            <input type="hidden" name="schedules[${scheduleCount}][day_number]" value="${scheduleCount + 1}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Địa điểm</label>
                        <input type="text" class="form-control" name="schedules[${scheduleCount}][location]" placeholder="VD: Hà Nội - Hạ Long">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hoạt động</label>
                        <textarea class="form-control" name="schedules[${scheduleCount}][activities]" rows="2" placeholder="Mô tả hoạt động trong ngày"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm form-control remove-schedule">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label>Ghi chú</label>
                <input type="text" class="form-control" name="schedules[${scheduleCount}][notes]" placeholder="VD: Mang theo CMND/CCCD">
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newItem);
        scheduleCount++;
    });

    // Xóa lịch trình
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-schedule')) {
            const scheduleItems = document.querySelectorAll('.schedule-item');
            if (scheduleItems.length > 1) {
                e.target.closest('.schedule-item').remove();
                // Cập nhật lại số ngày
                updateScheduleDayNumbers();
            }
        }
    });

    // Cập nhật lại số ngày sau khi xóa
    function updateScheduleDayNumbers() {
        const scheduleItems = document.querySelectorAll('.schedule-item');
        scheduleItems.forEach((item, index) => {
            const heading = item.querySelector('h5');
            if (heading) {
                heading.textContent = `Ngày ${index + 1}`;
            }
            const dayNumberInput = item.querySelector('input[name*="[day_number]"]');
            if (dayNumberInput) {
                dayNumberInput.value = index + 1;
            }
        });
        scheduleCount = scheduleItems.length;
    }
</script>

<style>
    html,
    body {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }
</style>

<?php
require_once __DIR__ . '/../layout/admin/footer.php';
?>