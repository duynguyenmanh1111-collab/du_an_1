<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="<?= BASE_URL ?>?act=<?= isAdmin() ? 'admin' : 'guide' ?>" class="brand-link">
      <img src="<?= asset('dist/assets/img/AdminLTELogo.png') ?>" alt="Logo" class="brand-image opacity-75 shadow"/>
      <span class="brand-text fw-light">Quản Lý Tour</span>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <?php if (isAdmin()): ?>
        <li class="nav-header">QUẢN TRỊ</li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>?act=admin" class="nav-link <?= ($_GET['act'] ?? '') === 'admin' ? 'active' : '' ?>">
            <i class="nav-icon bi bi-speedometer2"></i><p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?= in_array($_GET['act'] ?? '', ['tour-list', 'tour-add', 'tour-edit']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link"><i class="nav-icon bi bi-geo-alt"></i><p>Quản lý Tour<i class="nav-arrow bi bi-chevron-right"></i></p></a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=tour-list" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Danh sách Tour</p></a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=tour-add" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Thêm Tour</p></a></li>
          </ul>
        </li>
        <li class="nav-item <?= in_array($_GET['act'] ?? '', ['bookings', 'bookings-add', 'bookings-edit', 'bookings-detail']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link"><i class="nav-icon bi bi-calendar-check"></i><p>Quản lý Booking<i class="nav-arrow bi bi-chevron-right"></i></p></a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=bookings" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Danh sách Booking</p></a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=bookings-add" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Thêm Booking</p></a></li>
          </ul>
        </li>
        <li class="nav-item <?= in_array($_GET['act'] ?? '', ['admin-list-user', 'user-create', 'admin-edit-user']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link"><i class="nav-icon bi bi-people"></i><p>Quản lý User<i class="nav-arrow bi bi-chevron-right"></i></p></a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=admin-list-user" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Danh sách User</p></a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=user-create" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Thêm User</p></a></li>
          </ul>
        </li>
        <li class="nav-item <?= in_array($_GET['act'] ?? '', ['category', 'category-add', 'category-edit']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link"><i class="nav-icon bi bi-tags"></i><p>Danh mục Tour<i class="nav-arrow bi bi-chevron-right"></i></p></a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=category" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Danh sách</p></a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=category-add" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Thêm danh mục</p></a></li>
          </ul>
        </li>
        <li class="nav-item <?= in_array($_GET['act'] ?? '', ['destination-index', 'destination-create', 'destination-edit']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link"><i class="nav-icon bi bi-pin-map"></i><p>Điểm đến<i class="nav-arrow bi bi-chevron-right"></i></p></a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=destination-index" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Danh sách</p></a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=destination-create" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Thêm điểm đến</p></a></li>
          </ul>
        </li>
        <li class="nav-item <?= in_array($_GET['act'] ?? '', ['admin_guides', 'admin_guide_create', 'admin_guide_edit']) ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link"><i class="nav-icon bi bi-person-badge"></i><p>Hướng dẫn viên<i class="nav-arrow bi bi-chevron-right"></i></p></a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=admin_guides" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Danh sách</p></a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>?act=admin_guide_create" class="nav-link"><i class="nav-icon bi bi-circle"></i><p>Thêm HDV</p></a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= BASE_URL ?>?act=admin_reports" class="nav-link"><i class="nav-icon bi bi-file-earmark-text"></i><p>Báo cáo Tour</p></a>
        </li>
        <?php elseif (isGuide()): ?>
        <li class="nav-header">HƯỚNG DẪN VIÊN</li>
        <li class="nav-item"><a href="<?= BASE_URL ?>?act=guide" class="nav-link"><i class="nav-icon bi bi-speedometer2"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="<?= BASE_URL ?>?act=job-guide" class="nav-link"><i class="nav-icon bi bi-briefcase"></i><p>Công việc của tôi</p></a></li>
        <li class="nav-item"><a href="<?= BASE_URL ?>?act=account-guide" class="nav-link"><i class="nav-icon bi bi-person-circle"></i><p>Tài khoản</p></a></li>
        <?php endif; ?>
        <li class="nav-header">HỆ THỐNG</li>
        <?php if (isAdmin()): ?>
        <li class="nav-item"><a href="<?= BASE_URL ?>?act=my-account" class="nav-link"><i class="nav-icon bi bi-person-circle"></i><p>Tài khoản của tôi</p></a></li>
        <?php endif; ?>
        <li class="nav-item"><a href="<?= BASE_URL ?>?act=logout" class="nav-link"><i class="nav-icon bi bi-box-arrow-right"></i><p>Đăng xuất</p></a></li>
      </ul>
    </nav>
  </div>
</aside>
