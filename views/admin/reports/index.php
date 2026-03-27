<?php require_once './views/layout/admin-header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">📑 Danh sách báo cáo tour của hướng dẫn viên</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Tour</th>
                <th>Hướng dẫn viên</th>
                <th>Tóm tắt</th>
                <th>Tình hình khách</th>
                <th>Sự cố</th>
                <th>Gợi ý cải thiện</th>
                <th>Ảnh</th>
                <th>Ngày gửi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $r): ?>
                <tr>
                    <td><?= $r['booking_id'] ?></td>
                    <td><?= htmlspecialchars($r['tour_name']) ?></td>
                    <td><?= htmlspecialchars($r['guide_name']) ?></td>

                    <td><?= nl2br(htmlspecialchars($r['tour_summary'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($r['customer_situation'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($r['incidents'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($r['suggestions'])) ?></td>

                    <td style="max-width: 250px;">
                        <?php if (!empty($r['images'])): ?>
                            <?php foreach ($r['images'] as $img): ?>
                                <img src="<?= $img ?>" 
                                     style="width: 80px; height: 80px; object-fit: cover; margin: 3px; border-radius: 4px;">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <em>Không có ảnh</em>
                        <?php endif; ?>
                    </td>

                    <td><?= $r['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once './views/layout/admin-footer.php'; ?>
