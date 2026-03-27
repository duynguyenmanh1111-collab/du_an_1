<?php ob_start(); ?>

<div class="card">
    <div class="card-header"><h3 class="card-title">Thêm danh mục</h3></div>
    <form action="<?= BASE_URL ?>?act=category-handle-add" method="POST">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            <a href="<?= BASE_URL ?>?act=category" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['title' => $title, 'pageTitle' => 'Thêm danh mục', 'content' => $content, 'breadcrumb' => [['label' => 'Danh mục', 'url' => BASE_URL.'?act=category'], ['label' => 'Thêm mới', 'active' => true]]]);
?>
