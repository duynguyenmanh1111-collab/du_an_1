<?php
require_once __DIR__ . '/../../layout/admin/header.php';
// echo json_encode($bookings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
$user = $_SESSION['user'];
var_dump(strtolower(trim($user['role'])));

/* ======== GIẢI MÃ JSON AN TOÀN ======== */
foreach ($bookings as &$item) {
    $item['destination']      = !empty($item['destination'])      ? json_decode($item['destination'], true)      : [];
    $item['transports']       = !empty($item['transports'])       ? json_decode($item['transports'], true)       : [];
    $item['accommodations']   = !empty($item['accommodations'])   ? json_decode($item['accommodations'], true)   : [];
    $item['schedules']        = !empty($item['schedules'])        ? json_decode($item['schedules'], true)        : [];
    $item['tour']             = !empty($item['tour'])             ? json_decode($item['tour'], true)             : [];
    $item['customer']         = !empty($item['customer'])         ? json_decode($item['customer'], true)         : [];
    $item['people']           = !empty($item['people'])           ? json_decode($item['people'], true)           : [];
    $item['user']           = !empty($item['user'])           ? json_decode($item['user'], true)           : [];
    $item['guide']           = !empty($item['guide'])           ? json_decode($item['guide'], true)           : [];
    $item['category']           = !empty($item['category'])           ? json_decode($item['category'], true)           : [];
}
?>

<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <div class="tables">
            <h2 class="title1">Quản lý Booking</h2>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Danh sách Booking</h4>
                </div>

                <div class="panel-body">
                    <a href="index.php?act=bookings-add" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Thêm mới
                    </a>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Tour</th>
                                    <th>Danh mục</th>
                                    <th>Số lượng người</th>
                                    <!-- <th>Mô tả</th> -->
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Điểm đến</th>
                                    <th>Hướng dẫn viên</th>
                                    <!-- <th>Phương tiện</th> -->
                                    <!-- <th>Khách sạn</th> -->
                                    <!-- <th>Lịch trình</th> -->
                                    <!-- <th>Khách hàng</th> -->
                                    <th>Cập nhật</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($bookings as $data): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($data['id']) ?></td>

                                        <!-- TÊN TOUR -->
                                        <td><?= htmlspecialchars($data['tour']['name'] ?? 'Chưa có') ?></td>

                                        <td><?= htmlspecialchars($data['category']['name'] ?? '---') ?></td>

                                        <td><?= htmlspecialchars($data['number_of_people'] ?? 0) ?></td>

                                        <!-- MÔ TẢ -->
                                        <!-- <td style="min-width:200px">
                                            <?= htmlspecialchars(substr($data['destination']['description'] ?? 'Chưa có mô tả', 0, 200)) ?>
                                        </td> -->

                                        <td><?= date('d/m/Y', strtotime($data['start_date'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($data['end_date'])) ?></td>

                                        <td>
                                            <strong>
                                                <?= isset($data['tour']['price']) ? number_format($data['tour']['price'], 0, ',', '.') . ' VNĐ' : '---' ?>
                                            </strong>
                                        </td>

                                        <td>
                                            <?php
                                            $status = $data['status'];

                                            if ($status == 'pending') {
                                                echo '<span class="label label-warning">Chờ khởi hành</span>';
                                            } elseif ($status == 'confirmed') {
                                                echo '<span class="label label-success">Đang khởi hành</span>';
                                            } elseif ($status == 'cancelled') {
                                                echo '<span class="label label-danger">Đã hủy</span>';
                                            } elseif ($status == 'completed') {
                                                echo '<span class="label label-info">Hoàn thành</span>';
                                            }
                                            ?>
                                        </td>

                                        <!-- ĐIỂM ĐẾN -->
                                        <td>
                                            <?php if (!empty($data['destination'])): ?>
                                                <strong><?= htmlspecialchars($data['destination']['name'] ?? 'Không có tên') ?></strong><br>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($data['destination']['location'] ?? 'Không có địa điểm') ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td>


                                        <!-- HDV -->
                                        <td style="min-width: 200px;">
                                            <?php if (!empty($data['guide']) && is_array($data['guide'])): ?>
                                                <div class="guide-item" style="margin-bottom: 8px; padding: 5px; background: #f5f5f5; border-radius: 3px;">
                                                    <strong><?= htmlspecialchars($data['guide']['full_name'] ?? '') ?></strong><br>
                                                    <small>
                                                        <i class="fa fa-phone"></i> <?= htmlspecialchars($data['user']['phone'] ?? '') ?><br>
                                                        <i class="fa fa-envelope"></i> <?= htmlspecialchars($data['user']['email'] ?? '') ?>
                                                    </small>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Phương tiện -->
                                        <!-- <td style="min-width: 200px;">
                                            <?php if (!empty($data['transports'])): ?>
                                                <?php foreach ($data['transports'] as $transport): ?>
                                                    <div class="transport-item" style="margin-bottom: 8px; padding: 5px; background: #f5f5f5; border-radius: 3px;">
                                                        <strong><?= htmlspecialchars($transport['type']) ?></strong><br>
                                                        <small>
                                                            <i class="fa fa-users"></i> <?= $transport['seats'] ?> chỗ<br>
                                                            <i class="fa fa-building"></i> <?= htmlspecialchars($transport['company']) ?>
                                                        </small>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td> -->

                                        <!-- Khách sạn -->
                                        <!-- <td style="min-width: 200px;">
                                            <?php if (!empty($data['accommodations'])): ?>
                                                <?php foreach ($data['accommodations'] as $accommodation): ?>
                                                    <div class="accommodation-item" style="margin-bottom: 8px; padding: 5px; background: #f5f5f5; border-radius: 3px;">
                                                        <strong><?= htmlspecialchars($accommodation['name']) ?></strong><br>
                                                        <small>
                                                            <i class="fa fa-hotel"></i> <?= htmlspecialchars($accommodation['type']) ?><br>
                                                            <i class="fa fa-map-marker"></i> <?= htmlspecialchars($accommodation['address']) ?>
                                                        </small>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td> -->

                                        <!-- Lịch trình -->
                                        <!-- <td style="min-width: 300px;">
                                            <?php if (!empty($data['schedules'])): ?>
                                                <?php foreach ($data['schedules'] as $schedule): ?>
                                                    <div class="schedule-item" style="margin-bottom: 10px; padding: 8px; background: #f9f9f9; border-left: 3px solid #5cb85c; border-radius: 3px;">
                                                        <div style="margin-bottom: 5px;">
                                                            <strong style="color: #5cb85c;">Ngày <?= $schedule['day_number'] ?>:</strong>
                                                            <span style="color: #666;"><?= date('d/m/Y', strtotime($schedule['date'])) ?></span>
                                                        </div>
                                                        <div style="margin-bottom: 5px;">
                                                            <strong><i class="fa fa-map-marker"></i> <?= htmlspecialchars($schedule['location']) ?></strong>
                                                        </div>
                                                        <div style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                            <?= htmlspecialchars(substr($schedule['activities'], 0, 100)) ?>
                                                        </div>
                                                        <?php if (!empty($schedule['notes'])): ?>
                                                            <div style="font-size: 11px; color: #d9534f; font-style: italic;">
                                                                <i class="fa fa-info-circle"></i> <?= htmlspecialchars($schedule['notes']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có lịch trình</span>
                                            <?php endif; ?>
                                        </td> -->
                                        <!-- Khách hàng -->
                                        <!-- <td style="min-width: 200px;">
                                            <?php if (!empty($data['people'])): ?>
                                                <?php foreach ($data['people'] as $person): ?>
                                                    <div class="people-item" style="margin-bottom: 8px; padding: 5px; background: #f5f5f5; border-radius: 3px;">
                                                        <strong><?= htmlspecialchars($person['fullname']) ?></strong><br>
                                                        <small>
                                                            <i class="fa fa-users"></i> <?= $person['date'] ?> chỗ<br>
                                                            <i class="fa fa-phone"></i> <?= htmlspecialchars($person['phone']) ?>
                                                        </small>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </td> -->

                                        <td><?= date('d/m/Y H:i', strtotime($data['updated_at'])) ?></td>

                                        <td style="min-width:120px">
                                            <a href="index.php?act=bookings-edit&id=<?= $data['id'] ?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            <!-- <a href="index.php?act=bookings-delete&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc muốn xóa tour này?')">
                                                <i class="fa fa-trash"></i> Xóa
                                            </a> -->
                                            <a href="index.php?act=bookings-detail&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Xem chi tiết
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<style>
    html,
    body {
        overflow: auto !important;
        height: auto !important;
    }

    .table td {
        vertical-align: top !important;
    }

    .transport-item {
        border-left: 3px solid #337ab7;
        padding: 5px;
        background: #f5f5f5;
        margin-bottom: 8px;
    }

    .accommodation-item {
        border-left: 3px solid #f484f4ff;
        padding: 5px;
        background: #f5f5f5;
        margin-bottom: 8px;
    }

    .guide-item {
        border-left: 3px solid #916ef1ff;
        padding: 5px;
        background: #f5f5f5;
        margin-bottom: 8px;
    }

    .people-item {
        border-left: 3px solid #f19e4eff;
        padding: 5px;
        background: #f5f5f5;
        margin-bottom: 8px;
    }

    .schedule-item {
        margin-bottom: 10px;
        padding: 8px;
        border-left: 3px solid #5cb85c;
        background: #f9f9f9;
    }
</style>

<?php require_once __DIR__ . '/../../layout/admin/footer.php'; ?>