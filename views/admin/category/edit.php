<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Sửa danh mục</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form cập nhật thông tin danh mục:</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=category-update">
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?= isset($category['id']) ? $category['id'] : '' ?>">

                        <!-- Tên danh mục -->
                        <div class="form-group">
                            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= isset($category['name']) ? htmlspecialchars($category['name']) : '' ?>"
                                placeholder="Nhập tên danh mục" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <input type="text" class="form-control" id="description" name="description"
                                value="<?= isset($category['description']) ? htmlspecialchars($category['description']) : '' ?>"
                                placeholder="Nhập mô tả danh mục" required>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary" name="update">
                                <i class="fa fa-save"></i> Cập nhật
                            </button>
                            <a href="index.php?act=QlDanhMuc" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
?>