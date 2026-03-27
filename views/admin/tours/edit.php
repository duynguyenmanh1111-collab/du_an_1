<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Tour</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=tour-update" method="POST">
        <input type="hidden" name="id" value="<?= $tour['id'] ?>">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên Tour <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($tour['name']) ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Chọn --</option>
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($tour['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Điểm đến</label>
                        <select name="destination_id" class="form-select">
                            <option value="">-- Chọn --</option>
                            <?php foreach ($destinations as $dest): ?>
                            <option value="<?= $dest['id'] ?>" <?= ($tour['destination_id'] ?? '') == $dest['id'] ? 'selected' : '' ?>><?= htmlspecialchars($dest['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Giá (VNĐ)</label>
                        <input type="number" name="price" class="form-control" value="<?= $tour['price'] ?? 0 ?>" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="open" <?= ($tour['status'] ?? '') == 'open' ? 'selected' : '' ?>>Mở</option>
                            <option value="closed" <?= ($tour['status'] ?? '') == 'closed' ? 'selected' : '' ?>>Đóng</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($tour['description'] ?? '') ?></textarea>
            </div>

            <!-- Lịch trình -->
            <h5 class="mt-4 mb-3">Lịch trình Tour</h5>
            <div id="schedules-container">
                <?php if (!empty($schedules)): ?>
                    <?php foreach ($schedules as $index => $schedule): ?>
                    <div class="card mb-2 schedule-item">
                        <div class="card-body">
                            <input type="hidden" name="schedules[<?= $index ?>][id]" value="<?= $schedule['id'] ?? '' ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label">Ngày</label>
                                    <input type="number" name="schedules[<?= $index ?>][day_number]" class="form-control" value="<?= $schedule['day_number'] ?? ($index + 1) ?>" min="1">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Địa điểm</label>
                                    <input type="text" name="schedules[<?= $index ?>][location]" class="form-control" value="<?= htmlspecialchars($schedule['location'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Hoạt động</label>
                                    <input type="text" name="schedules[<?= $index ?>][activities]" class="form-control" value="<?= htmlspecialchars($schedule['activities'] ?? '') ?>">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label class="form-label">Ghi chú</label>
                                <input type="text" name="schedules[<?= $index ?>][notes]" class="form-control" value="<?= htmlspecialchars($schedule['notes'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="card mb-2 schedule-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Ngày</label>
                                <input type="number" name="schedules[0][day_number]" class="form-control" value="1" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Địa điểm</label>
                                <input type="text" name="schedules[0][location]" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hoạt động</label>
                                <input type="text" name="schedules[0][activities]" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-schedule" style="display:none;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Ghi chú</label>
                            <input type="text" name="schedules[0][notes]" class="form-control">
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <button type="button" id="add-schedule" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-plus"></i> Thêm ngày
            </button>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <a href="<?= BASE_URL ?>?act=tour-list" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<script>
let scheduleIndex = <?= !empty($schedules) ? count($schedules) : 1 ?>;
document.getElementById('add-schedule').addEventListener('click', function() {
    const container = document.getElementById('schedules-container');
    const html = `
        <div class="card mb-2 schedule-item">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Ngày</label>
                        <input type="number" name="schedules[${scheduleIndex}][day_number]" class="form-control" value="${scheduleIndex + 1}" min="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Địa điểm</label>
                        <input type="text" name="schedules[${scheduleIndex}][location]" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hoạt động</label>
                        <input type="text" name="schedules[${scheduleIndex}][activities]" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-schedule">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <label class="form-label">Ghi chú</label>
                    <input type="text" name="schedules[${scheduleIndex}][notes]" class="form-control">
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    scheduleIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-schedule')) {
        e.target.closest('.schedule-item').remove();
    }
});
</script>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Sửa Tour',
    'pageTitle' => 'Sửa Tour',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Tour', 'url' => BASE_URL . '?act=tour-list'],
        ['label' => 'Sửa', 'active' => true]
    ]
]);
?>
