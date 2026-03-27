<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm điểm đến mới</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=destination-store" method="POST">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Tên điểm đến <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa điểm</label>
                <input type="text" name="location" class="form-control" placeholder="Ví dụ: Hà Nội, Việt Nam">
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            <a href="<?= BASE_URL ?>?act=destination" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Thêm điểm đến',
    'pageTitle' => 'Thêm điểm đến mới',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Điểm đến', 'url' => BASE_URL . '?act=destination'],
        ['label' => 'Thêm mới', 'active' => true]
    ]
]);
?>
