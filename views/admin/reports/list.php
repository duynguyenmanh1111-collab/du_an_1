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
            <h2 class="title1">Quản lý báo cáo</h2>

            <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                <h4>Danh sách báo cáo từ hướng dẫn viên:</h4>

                <!-- Bảng danh sách -->
                <table class="table table-hover table-bordered report-table">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th width="100">Ảnh</th>
                            <th>Tour</th>
                            <th>Hướng dẫn viên</th>
                            <th width="180">Ngày gửi</th>
                            <th width="150">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reports)): ?>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="id-badge"><?= $report['id'] ?></span>
                                    </td>

                                    <!-- Ảnh đại diện -->
                                    <td class="text-center">
                                        <?php
                                        $img = $report['images'][0] ?? null;
                                        $src = $img ?: "https://via.placeholder.com/80/667eea/ffffff?text=No+Image";
                                        ?>
                                        <img src="<?= $src ?>" class="report-img" alt="Tour image">
                                    </td>

                                    <!-- Thông tin Tour -->
                                    <td>
                                        <div class="tour-info">
                                            <strong><?= htmlspecialchars($report['tour_name']) ?></strong>
                                            <div class="tour-location">
                                                <i class="fa fa-map-marker"></i>
                                                <span>Khám phá Hà Nội 3N2D</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Hướng dẫn viên -->
                                    <td>
                                        <div class="guide-info">
                                            <div class="guide-avatar">
                                                <?= strtoupper(substr($report['guide_name'], 0, 1)) ?>
                                            </div>
                                            <span><?= htmlspecialchars($report['guide_name']) ?></span>
                                        </div>
                                    </td>

                                    <!-- Ngày gửi -->
                                    <td class="text-center">
                                        <span class="date-badge">
                                            <i class="fa fa-clock-o"></i>
                                            <?= date('d-m-Y H:i', strtotime($report['created_at'])) ?>
                                        </span>
                                    </td>

                                    <!-- Hành động -->
                                    <td class="text-center">
                                        <a href="index.php?act=report-detail&id=<?= $report['id'] ?>"
                                            class="btn btn-primary btn-sm action-btn">
                                            <i class="fa fa-eye"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="empty-state">
                                        <i class="fa fa-inbox" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                                        <p style="padding: 20px; color: #999;">Chưa có báo cáo nào. Các báo cáo từ hướng dẫn viên sẽ hiển thị tại đây!</p>
                                    </div>
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

    /* ===== CUSTOM STYLES FOR REPORT TABLE ===== */

    .report-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .report-table thead th {
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        padding: 15px 12px;
    }

    .report-table tbody tr {
        transition: all 0.2s ease;
    }

    .report-table tbody tr:hover {
        background-color: #f8f9ff;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    .report-table tbody td {
        vertical-align: middle;
        padding: 15px 12px;
    }

    /* ID Badge */
    .id-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
    }

    /* Report Image */
    .report-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        border: 3px solid #e8ebf9;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .report-img:hover {
        transform: scale(1.15) rotate(2deg);
        border-color: #667eea;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    /* Tour Info */
    .tour-info strong {
        display: block;
        color: #2d3748;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .tour-location {
        color: #718096;
        font-size: 13px;
    }

    .tour-location i {
        margin-right: 5px;
        color: #667eea;
    }

    /* Guide Info */
    .guide-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .guide-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 16px;
    }

    .guide-info span {
        color: #2d3748;
        font-weight: 500;
    }

    /* Date Badge */
    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(245, 87, 108, 0.25);
    }

    .date-badge i {
        font-size: 14px;
    }

    /* Action Button */
    .action-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.25);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        color: white;
        background: linear-gradient(135deg, #5568d3 0%, #6b3a9e 100%);
    }

    .action-btn i {
        margin-right: 5px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    /* Widget Shadow Enhancement */
    .widget-shadow {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .widget-shadow h4 {
        background: linear-gradient(to right, #f8f9ff, #ffffff);
        padding: 15px 20px;
        margin: 0;
        border-bottom: 2px solid #e8ebf9;
        color: #2d3748;
        font-weight: 600;
    }

    /* Title Enhancement */
    .title1 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #667eea;
        display: inline-block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .report-img {
            width: 60px;
            height: 60px;
        }

        .tour-info strong {
            font-size: 14px;
        }

        .guide-avatar {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }

        .date-badge {
            font-size: 11px;
            padding: 6px 10px;
        }

        .action-btn {
            padding: 6px 12px;
            font-size: 12px;
        }

        .report-table thead th {
            font-size: 11px;
            padding: 12px 8px;
        }

        .report-table tbody td {
            padding: 12px 8px;
        }
    }
</style>

<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
?>