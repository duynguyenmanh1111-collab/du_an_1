<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- header-starts -->
<div class="sticky-header header-section ">
    <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <div class="profile_details_left">
            <!--notifications of menu start -->
            <ul class="nofitications-dropdown">
                <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">4</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="notification_header">
                                <h3>You have 3 new messages</h3>
                            </div>
                        </li>
                        <li>
                            <div class="notification_bottom">
                                <a href="#">See all messages</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown head-dpdn">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">4</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="notification_header">
                                <h3>You have 3 new notification</h3>
                            </div>
                        </li>
                        <li>
                            <div class="notification_bottom">
                                <a href="#">See all notifications</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="clearfix"> </div>
        </div>
        <!--notification menu end -->
        <div class="clearfix"> </div>
    </div>
    <div class="header-right">
        <!--search-box-->
        <div class="search-box">
            <form class="input">
                <input class="sb-search-input input__field--madoka" placeholder="Search..." type="search" id="input-31" />
                <label class="input__label" for="input-31">
                    <svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77" preserveAspectRatio="none">
                        <path d="m0,0l404,0l0,77l-404,0l0,-77z" />
                    </svg>
                </label>
            </form>
        </div>
        <!--//end-search-box-->

        <div class="profile_details">
            <ul>
                <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile_img">
                            <span class="prfil-img"><img src="images/2.jpg" alt=""> </span>
                            <div class="user-name">
                                <p>Admin Name</p>
                                <span>Administrator</span>
                            </div>
                            <i class="fa fa-angle-down lnr"></i>
                            <i class="fa fa-angle-up lnr"></i>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu drp-mnu">
                        <li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li>
                        <li> <a href="#"><i class="fa fa-user"></i> My Account</a> </li>
                        <li> <a href="#"><i class="fa fa-suitcase"></i> Profile</a> </li>
                        <li> <a href="#"><i class="fa fa-sign-out"></i> Logout</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="clearfix"> </div>
</div>
<!-- //header-ends -->

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="tables">
            <h2 class="title1">Quản lý Danh mục</h2>

            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <h4>Danh sách danh mục:</h4>

                <!-- Nút thêm mới -->
                <div class="mb-3" style="margin-bottom: 15px;">
                    <a href="?act=category-add" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Thêm danh mục
                    </a>
                </div>

                <!-- Bảng danh sách -->
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cate): ?>
                                <tr>
                                    <th scope="row"><?= $cate['id'] ?></th>
                                    <td><?= htmlspecialchars($cate['name']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($cate['description']) ?>
                                    </td>
                                    <td>
                                        <a href="?act=category-edit&id=<?= $cate['id'] ?>" class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')"
                                            href="?act=category-delete&id=<?= $cate['id'] ?>"
                                            class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <p style="padding: 20px; color: #999;">Chưa có danh mục nào. Vui lòng thêm mới!</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    /* Mở khóa cuộn toàn trang */
    html,
    body {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    /* Một số template admin cũ khóa wrapper */
    #wrapper,
    .wrapper {
        overflow: auto !important;
        height: auto !important;
        max-height: none !important;
    }

    /* Đây là vùng gây lỗi scroll nhiều nhất */
    #page-wrapper,
    .content-wrapper {
        overflow: auto !important;
        height: auto !important;
        min-height: 100vh !important;
        max-height: none !important;
    }

    /* Các khối bên trong cũng phải mở khóa */
    .main-page,
    .right_col,
    .container,
    .tables,
    .panel-body {
        overflow: visible !important;
        height: auto !important;
    }

    /* Khắc phục bảng bị tràn nhưng không cuộn */
    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }

    /* Fix theme đặt chiều cao cố định */
    body,
    #wrapper,
    #page-wrapper {
        position: static !important;
    }
</style>

<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
?>