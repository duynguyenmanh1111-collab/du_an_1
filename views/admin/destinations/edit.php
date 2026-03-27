<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa điểm đến</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=destination-update" method="POST">
        <input type="hidden" name="id" value="<?= $destination['id'] ?>">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Tên điểm đến <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($destination['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa điểm</label>
                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($destination['location'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($destination['description'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <a href="<?= BASE_URL ?>?act=destination" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Sửa điểm đến',
    'pageTitle' => 'Sửa điểm đến',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Điểm đến', 'url' => BASE_URL . '?act=destination'],
        ['label' => 'Sửa', 'active' => true]
    ]
]);
?>
