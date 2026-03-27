<?php
require_once __DIR__ . '/../../layout/admin/header.php';
?>

<!-- header-starts -->


<!-- main content start-->
<div id="page-wrapper">
    <div class="main-page">
        <h2 class="mb-3 text-center">Danh sách hướng dẫn viên</h2>
    <a href="?act=admin_guide_create" class="btn btn-primary mb-3 ">+ Thêm hướng dẫn viên</a>
    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Chuyên môn</th>
                <th>Kinh nghiệm (năm)</th>
                <th>Ngôn ngữ</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guides as $g): ?>
                <tr>
                    <td><?= $g['id'] ?></td>
                    <td><?= htmlspecialchars($g['full_name']) ?></td>
                    <td><?= htmlspecialchars($g['specialization']) ?></td>
                    <td><?= $g['experience_years'] ?></td>
                    <td><?= htmlspecialchars($g['languages']) ?></td>
                    <td><?= htmlspecialchars($g['status']) ?></td>
                    <td class="text-center">
                        <a href="?act=admin_guide_edit&id=<?= $g['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <!-- <a href="?act=admin_guide_delete&id=<?= $g['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Xóa hướng dẫn viên này?')">Xóa</a> -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../../layout/admin/footer.php';
?>

