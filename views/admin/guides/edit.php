<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa hướng dẫn viên</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=admin_guide_update&id=<?= $guide['id'] ?>" method="POST">
        <input type="hidden" name="id" value="<?= $guide['id'] ?>">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($guide['full_name']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tài khoản User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Chọn tài khoản --</option>
                            <?php if (!empty($availableUsers)): ?>
                                <?php foreach ($availableUsers as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= ($guide['user_id'] ?? '') == $user['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['full_name'] . ' (' . ($user['username'] ?? $user['email']) . ')') ?>
                                </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Chuyên môn</label>
                        <input type="text" name="specialization" class="form-control" value="<?= htmlspecialchars($guide['specialization'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Kinh nghiệm (năm)</label>
                        <input type="number" name="experience_years" class="form-control" value="<?= $guide['experience_years'] ?? 0 ?>" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= ($guide['status'] ?? '') == 'active' ? 'selected' : '' ?>>Đang hoạt động</option>
                            <option value="available" <?= ($guide['status'] ?? '') == 'available' ? 'selected' : '' ?>>Sẵn sàng</option>
                            <option value="inactive" <?= ($guide['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Tạm nghỉ</option>
                            <option value="busy" <?= ($guide['status'] ?? '') == 'busy' ? 'selected' : '' ?>>Đang bận</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Ngôn ngữ</label>
                        <input type="text" name="languages" class="form-control" value="<?= htmlspecialchars($guide['languages'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Chứng chỉ</label>
                        <input type="text" name="certificates" class="form-control" value="<?= htmlspecialchars($guide['certificates'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật</button>
            <a href="<?= BASE_URL ?>?act=admin_guides" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Sửa HDV',
    'pageTitle' => 'Sửa hướng dẫn viên',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Hướng dẫn viên', 'url' => BASE_URL . '?act=admin_guides'],
        ['label' => 'Sửa', 'active' => true]
    ]
]);
?>
