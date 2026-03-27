<?php
require_once __DIR__ . '/../layout/admin/header.php';

// Decode JSON data nếu cần
if (isset($DataQltour['destination']) && is_string($DataQltour['destination'])) {
    $DataQltour['destination'] = json_decode($DataQltour['destination'], true);
}
// if (isset($DataQltour['transports']) && is_string($DataQltour['transports'])) {
//     $DataQltour['transports'] = json_decode($DataQltour['transports'], true);
// }
// if (isset($DataQltour['accommodations']) && is_string($DataQltour['accommodations'])) {
//     $DataQltour['accommodations'] = json_decode($DataQltour['accommodations'], true);
// }
if (isset($DataQltour['schedules']) && is_string($DataQltour['schedules'])) {
    $DataQltour['schedules'] = json_decode($DataQltour['schedules'], true);
}
?>


<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Cập nhật Tour</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form cập nhật thông tin Tour:</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=updateqltour" enctype="multipart/form-data">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?php echo isset($DataQltour['id']) ? $DataQltour['id'] : ''; ?>">

                        <h4 class="text-primary" style="margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #337ab7; padding-bottom: 10px;">
                            <i class="fa fa-info-circle"></i> Thông tin cơ bản
                        </h4>

                        <!-- Tên Tour -->
                        <div class="form-group">
                            <label for="name">Tên Tour <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo isset($DataQltour['name']) ? htmlspecialchars($DataQltour['name']) : ''; ?>"
                                placeholder="Nhập tên tour" required>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>

                                <?php foreach ($allCategory as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"
                                        <?php echo (isset($DataQltour['category_id']) && $DataQltour['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>


                        <!-- Điểm đến -->
                        <div class="form-group">
                            <label for="destination_id">Điểm đến <span class="text-danger">*</span></label>
                            <select class="form-control" id="destination_id" name="destination_id" required>
                                <option value="">-- Chọn điểm đến --</option>
                                <?php if (isset($allDestination) && is_array($allDestination)): ?>
                                    <?php foreach ($allDestination as $destination): ?>
                                        <option value="<?php echo $destination['id']; ?>"
                                            <?php echo (isset($DataQltour['destination_id']) && $DataQltour['destination_id'] == $destination['id']) ? 'selected' : ''; ?>>
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
                                placeholder="Nhập mô tả tour"><?php echo isset($DataQltour['description']) ? htmlspecialchars($DataQltour['description']) : ''; ?></textarea>
                        </div>


                        <!-- LỊCH TRÌNH -->
                        <h4 class="text-info" style="margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #5bc0de; padding-bottom: 10px;">
                            <i class="fa fa-calendar"></i> Lịch trình chi tiết
                        </h4>

                        <div id="schedules-container">
                            <?php
                            // SỬA: Thống nhất biến schedules
                            if (isset($DataQltour['schedules']) && is_array($DataQltour['schedules'])) {
                                $schedules = $DataQltour['schedules'];
                            } else {
                                $schedules = [['day_number' => 1, 'date' => '', 'location' => '', 'activities' => '', 'notes' => '']];
                            }

                            foreach ($schedules as $index => $schedule):
                            ?>
                                <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
                                    <?php if (isset($schedule['id']) && !empty($schedule['id'])): ?>
                                        <input type="hidden" name="schedules[<?= $index ?>][id]" value="<?= $schedule['id'] ?>">
                                    <?php endif; ?>

                                    <h5 style="margin-top: 0;">Ngày <?= isset($schedule['day_number']) ? $schedule['day_number'] : ($index + 1) ?></h5>
                                    <input type="hidden" name="schedules[<?= $index ?>][day_number]" value="<?= $index + 1 ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ngày</label>
                                                <input type="date" class="form-control" name="schedules[<?= $index ?>][date]"
                                                    value="<?= isset($schedule['date']) ? $schedule['date'] : '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Địa điểm</label>
                                                <input type="text" class="form-control" name="schedules[<?= $index ?>][location]"
                                                    value="<?= isset($schedule['location']) ? htmlspecialchars($schedule['location']) : '' ?>"
                                                    placeholder="VD: Hà Nội - Hạ Long">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hoạt động</label>
                                                <textarea class="form-control" name="schedules[<?= $index ?>][activities]" rows="2"
                                                    placeholder="Mô tả hoạt động trong ngày"><?= isset($schedule['activities']) ? htmlspecialchars($schedule['activities']) : '' ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm form-control remove-schedule" <?= $index == 0 ? 'style="display:none;"' : '' ?>>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Ghi chú</label>
                                        <input type="text" class="form-control" name="schedules[<?= $index ?>][notes]"
                                            value="<?= isset($schedule['notes']) ? htmlspecialchars($schedule['notes']) : '' ?>"
                                            placeholder="VD: Mang theo CMND/CCCD">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-schedule">
                            <i class="fa fa-plus"></i> Thêm ngày
                        </button>
                        <!-- Giá -->
                        <div class="form-group">
                            <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="<?php echo isset($DataQltour['price']) ? $DataQltour['price'] : ''; ?>"
                                placeholder="Nhập giá tour" min="0" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="open" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'open') ? 'selected' : ''; ?>>Mở đăng ký</option>
                                <option value="inactive" <?php echo (isset($DataQltour['status']) && $DataQltour['status'] == 'inactive') ? 'selected' : ''; ?>>Không hoạt động</option>
                            </select>
                        </div>


                        <!-- Buttons -->
                        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #ddd;">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Cập nhật Tour
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
    let scheduleCount = <?= count($schedules) ?>;

    // // Thêm phương tiện
    // document.getElementById('add-transport').addEventListener('click', function() {
    //     const container = document.getElementById('transports-container');
    //     const newItem = `
    //     <div class="transport-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9;">
    //         <h5 style="margin-top: 0;">Phương tiện #${transportCount + 1}</h5>
    //         <div class="row">
    //             <div class="col-md-4">
    //                 <div class="form-group">
    //                     <label>Loại phương tiện</label>
    //                     <input type="text" class="form-control" name="transports[${transportCount}][type]" placeholder="VD: Xe du lịch 45 chỗ">
    //                 </div>
    //             </div>
    //             <div class="col-md-3">
    //                 <div class="form-group">
    //                     <label>Số chỗ</label>
    //                     <input type="number" class="form-control" name="transports[${transportCount}][seats]" placeholder="45">
    //                 </div>
    //             </div>
    //             <div class="col-md-4">
    //                 <div class="form-group">
    //                     <label>Công ty</label>
    //                     <input type="text" class="form-control" name="transports[${transportCount}][company]" placeholder="VD: Hoàng Long Travel">
    //                 </div>
    //             </div>
    //             <div class="col-md-1">
    //                 <label>&nbsp;</label>
    //                 <button type="button" class="btn btn-danger btn-sm form-control remove-transport">
    //                     <i class="fa fa-trash"></i>
    //                 </button>
    //             </div>
    //         </div>
    //     </div>
    // `;
    //     container.insertAdjacentHTML('beforeend', newItem);
    //     transportCount++;
    // });

    // // Xóa phương tiện
    // document.addEventListener('click', function(e) {
    //     if (e.target.closest('.remove-transport')) {
    //         e.target.closest('.transport-item').remove();
    //     }
    // });

    // // Thêm khách sạn
    // document.getElementById('add-accommodation').addEventListener('click', function() {
    //     const container = document.getElementById('accommodations-container');
    //     const newItem = `
    //     <div class="accommodation-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fffbf0;">
    //         <h5 style="margin-top: 0;">Khách sạn #${accommodationCount + 1}</h5>
    //         <div class="row">
    //             <div class="col-md-4">
    //                 <div class="form-group">
    //                     <label>Tên khách sạn</label>
    //                     <input type="text" class="form-control" name="accommodations[${accommodationCount}][name]" placeholder="VD: Hạ Long Bay Resort">
    //                 </div>
    //             </div>
    //             <div class="col-md-3">
    //                 <div class="form-group">
    //                     <label>Loại</label>
    //                     <select class="form-control" name="accommodations[${accommodationCount}][type]">
    //                         <option value="">Chọn loại</option>
    //                         <option value="Hotel">Hotel</option>
    //                         <option value="Resort">Resort</option>
    //                         <option value="Homestay">Homestay</option>
    //                     </select>
    //                 </div>
    //             </div>
    //             <div class="col-md-4">
    //                 <div class="form-group">
    //                     <label>Địa chỉ</label>
    //                     <input type="text" class="form-control" name="accommodations[${accommodationCount}][address]" placeholder="VD: Bãi Cháy, Quảng Ninh">
    //                 </div>
    //             </div>
    //             <div class="col-md-1">
    //                 <label>&nbsp;</label>
    //                 <button type="button" class="btn btn-danger btn-sm form-control remove-accommodation">
    //                     <i class="fa fa-trash"></i>
    //                 </button>
    //             </div>
    //         </div>
    //     </div>
    // `;
    //     container.insertAdjacentHTML('beforeend', newItem);
    //     accommodationCount++;
    // });

    // // Xóa khách sạn
    // document.addEventListener('click', function(e) {
    //     if (e.target.closest('.remove-accommodation')) {
    //         e.target.closest('.accommodation-item').remove();
    //     }
    // });

    // Thêm lịch trình
    document.getElementById('add-schedule').addEventListener('click', function() {
        const container = document.getElementById('schedules-container');
        const newItem = `
        <div class="schedule-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f0f8ff;">
            <h5 style="margin-top: 0;">Ngày ${scheduleCount + 1}</h5>
            <input type="hidden" name="schedules[${scheduleCount}][day_number]" value="${scheduleCount + 1}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Ngày</label>
                        <input type="date" class="form-control" name="schedules[${scheduleCount}][date]">
                    </div>
                </div>
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

        // DEBUG: Kiểm tra xem có thêm được không
        console.log('Đã thêm lịch trình, tổng số:', scheduleCount);
    });

    // Xóa lịch trình
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-schedule')) {
            e.target.closest('.schedule-item').remove();
        }
    });
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