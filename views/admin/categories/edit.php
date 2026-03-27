<?php ob_start(); ?>

<div class="card">
    <div class="card-header"><h3 class="card-title">Sửa danh mục</h3></div>
    <form action="<?= BASE_URL ?>?act=category-handle-edit" method="POST">
        <input type="hidden" name="id" value="<?= $category['id'] ?>">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <a href="<?= BASE_URL ?>?act=category" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['title' => $title, 'pageTitle' => 'Sửa danh mục', 'content' => $content, 'breadcrumb' => [['label' => 'Danh mục', 'url' => BASE_URL.'?act=category'], ['label' => 'Sửa', 'active' => true]]]);
?>
