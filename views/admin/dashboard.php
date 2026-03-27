<?php
ob_start();
?>

<!-- Thông báo -->
<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['error'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error']); endif; ?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <!-- Tổng Booking -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3><?= number_format($bookingDone ?? 0) ?></h3>
                <p>Tổng Booking</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm-8 4H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"></path>
            </svg>
            <a href="<?= BASE_URL ?>?act=bookings" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Xem chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>

    <!-- Booking đang chạy -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3><?= number_format($bookingOngoing ?? 0) ?></h3>
                <p>Booking đang chạy</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm4.2 14.2L11 13V7h1.5v5.2l4.5 2.7-.8 1.3z"></path>
            </svg>
            <a href="<?= BASE_URL ?>?act=bookings" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Xem chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>

    <!-- Tổng khách hàng -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3><?= number_format($totalCustomers ?? 0) ?></h3>
                <p>Tổng khách hàng</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path>
            </svg>
            <a href="<?= BASE_URL ?>?act=bookings" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                Xem chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>

    <!-- Tổng hướng dẫn viên -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-info">
            <div class="inner">
                <h3><?= number_format($totalGuides ?? 0) ?></h3>
                <p>Hướng dẫn viên</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
            </svg>
            <a href="<?= BASE_URL ?>?act=admin_guides" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                Xem chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
</div>

<!-- Doanh thu -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-currency-dollar me-1"></i>
                    Tổng doanh thu
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-success mb-0">
                            <?= number_format($totalRevenue ?? 0, 0, ',', '.') ?> VNĐ
                        </h2>
                        <small class="text-muted">Doanh thu từ các booking đã hoàn thành</small>
                    </div>
                    <div>
                        <i class="bi bi-graph-up-arrow text-success" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-lightning me-1"></i>
                    Truy cập nhanh
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6 mb-3">
                        <a href="<?= BASE_URL ?>?act=tour-list" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-geo-alt d-block mb-2" style="font-size: 1.5rem;"></i>
                            Quản lý Tour
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="<?= BASE_URL ?>?act=bookings" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-calendar-check d-block mb-2" style="font-size: 1.5rem;"></i>
                            Quản lý Booking
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="<?= BASE_URL ?>?act=admin-list-user" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-people d-block mb-2" style="font-size: 1.5rem;"></i>
                            Quản lý User
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="<?= BASE_URL ?>?act=admin_guides" class="btn btn-outline-warning w-100 py-3">
                            <i class="bi bi-person-badge d-block mb-2" style="font-size: 1.5rem;"></i>
                            Hướng dẫn viên
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

view('layouts.AdminLayout', [
    'title' => $title ?? 'Dashboard',
    'pageTitle' => 'Dashboard',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Dashboard', 'url' => BASE_URL . '?act=admin', 'active' => true]
    ]
]);
?>
