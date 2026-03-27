<?php ob_start(); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm hướng dẫn viên mới</h3>
    </div>
    <form action="<?= BASE_URL ?>?act=admin_guide_store" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tài khoản User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Chọn tài khoản --</option>
                            <?php if (!empty($availableUsers)): ?>
                                <?php foreach ($availableUsers as $user): ?>
                                <option value="<?= $user['id'] ?>">
                                    <?= htmlspecialchars($user['full_name'] . ' (' . ($user['username'] ?? $user['email']) . ')') ?>
                                </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">Chọn user có role "guide" để liên kết</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Chuyên môn</label>
                        <input type="text" name="specialization" class="form-control" placeholder="Ví dụ: Du lịch biển, Du lịch núi...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Kinh nghiệm (năm)</label>
                        <input type="number" name="experience_years" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active">Đang hoạt động</option>
                            <option value="available">Sẵn sàng</option>
                            <option value="inactive">Tạm nghỉ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Ngôn ngữ</label>
                        <input type="text" name="languages" class="form-control" placeholder="Ví dụ: Tiếng Việt, Tiếng Anh, Tiếng Trung">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Chứng chỉ</label>
                        <input type="text" name="certificates" class="form-control" placeholder="Các chứng chỉ hành nghề">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Lưu</button>
            <a href="<?= BASE_URL ?>?act=admin_guides" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', [
    'title' => $title ?? 'Thêm HDV',
    'pageTitle' => 'Thêm hướng dẫn viên mới',
    'content' => $content,
    'breadcrumb' => [
        ['label' => 'Hướng dẫn viên', 'url' => BASE_URL . '?act=admin_guides'],
        ['label' => 'Thêm mới', 'active' => true]
    ]
]);
?>
