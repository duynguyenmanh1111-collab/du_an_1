<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Thêm Danh Mục</h2>

            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form thêm danh mục mới:</h4>
                </div>

                <div class="form-body">
                    <form method="POST" action="index.php?act=category-insert">

                        <!-- Tên danh mục -->
                        <div class="form-group">
                            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nhập tên danh mục" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Nhập mô tả danh mục" required>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" name="add" class="btn btn-success">
                                <i class="fa fa-plus"></i> Thêm
                            </button>

                            <a href="index.php?act=category" class="btn btn-default">
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