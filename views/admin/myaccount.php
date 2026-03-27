<?php require_once __DIR__ . '/../layout/admin/header.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <h1>Tài Khoản Của Tôi</h1>
        </div>

        <?php if ($user): ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fa fa-user"></i> Thông Tin Cá Nhân</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="200"><strong>Tên đăng nhập:</strong></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Họ và tên:</strong></td>
                                        <td><?= htmlspecialchars($user['full_name'] ?? 'Chưa cập nhật') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Số điện thoại:</strong></td>
                                        <td><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></td>
                                    </tr>

                                    <tr>
                                        <td><strong>Vai trò:</strong></td>
                                        <td>
                                            <?php
                                            $role = $user['role'] ?? 'guide';
                                            $roleText = match ($role) {
                                                'admin' => 'Quản trị viên',
                                                'guide' => 'Hướng dẫn viên',
                                                'customer' => 'Khách hàng',
                                                default => ucfirst($role)
                                            };
                                            ?>
                                            <span class="badge badge-<?= $role === 'admin' ? 'danger' : 'info' ?>">
                                                <?= $roleText ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Trạng thái:</strong></td>
                                        <td>
                                            <?php
                                            $status = $user['status'] ?? 'active';
                                            $statusText = $status === 'active' ? 'Hoạt động' : 'Vô hiệu hóa';
                                            ?>
                                            <span class="badge badge-<?= $status === 'active' ? 'success' : 'secondary' ?>">
                                                <?= $statusText ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ngày tạo:</strong></td>
                                        <td><?= isset($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'Không rõ' ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                <i class="fa fa-exclamation-triangle"></i> Bạn chưa đăng nhập. Vui lòng <a href="?act=login">đăng nhập</a> để xem thông tin tài khoản.
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .main-content {
        margin-left: 250px !important;
        padding: 20px !important;
    }

    @media (max-width: 991px) {
        .main-content {
            margin-left: 0 !important;
        }
    }

    .page-header {
        border-bottom: 2px solid #e5e5e5;
        padding-bottom: 15px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
        font-size: 16px;
    }

    .card-body {
        padding: 30px;
    }

    .table td {
        padding: 15px 10px;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    .badge {
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 500;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .badge-info {
        background-color: #17a2b8;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-secondary {
        background-color: #6c757d;
    }

    .badge-primary {
        background-color: #007bff;
    }
</style>

<?php require_once __DIR__ . '/../layout/admin/footer.php'; ?>