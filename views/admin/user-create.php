<?php
require_once __DIR__ . '/../layout/admin/header.php';
// print_r($DataQltour);
// Hiển thị thông báo lỗi
if (isset($_SESSION['errors'])) {
    echo '<div class="alert alert-danger">';
    foreach ($_SESSION['errors'] as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
    unset($_SESSION['errors']);
}

// Lấy dữ liệu cũ nếu có lỗi
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['old_data']);
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Thêm tài khoản</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Form thêm mới:</h4>
                </div>
                <div class="form-body">
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?act=user-store">


                        <!-- UserName -->
                        <div class="mb-4">
                            <label for="username">Tên người dùng</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email">Email người dùng</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="full_name">Họ và tên</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="">Vai trò</label>
                            <select name="role" class="form-control">
                                <option value="guide">guide</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Phone-->
                        <div class="mb-4">
                            <label for="phone">Số Điện thoại người dùng</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <!--Mật khẩu -->
                        <div class="mb-4">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <!-- Ngày tạo -->

                        <div class="mb-4">
                            <label for="">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                        <!-- Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="fa fa-save"></i> Thêm mới
                            </button>
                            <a href="<?= BASE_URL ?>?act=admin-list-user">
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
require_once __DIR__ . '/../layout/admin/footer.php';
?>